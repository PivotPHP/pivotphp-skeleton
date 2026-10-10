<?php

declare(strict_types=1);

namespace Tests;

use Nyholm\Psr7\Factory\Psr17Factory;
use PHPUnit\Framework\TestCase;
use PivotPHP\Core\Core\Application;
use Psr\Http\Message\ResponseInterface;

/**
 * Exercises the real application (bootstrap/app.php) through Application::handle().
 */
final class ApiTest extends TestCase
{
    private const ORIGIN = 'http://localhost:5173';

    private Application $app;
    private Psr17Factory $factory;

    /**
     * Real environment variables take precedence over .env, so the tests do not depend on the
     * project's .env file.
     */
    private const ENV = [
        'APP_ENV' => 'testing',
        'APP_DEBUG' => 'false',
        'CORS_ALLOWED_ORIGINS' => self::ORIGIN,
    ];

    protected function setUp(): void
    {
        foreach (self::ENV as $key => $value) {
            putenv("{$key}={$value}");
            $_ENV[$key] = $value;
        }

        $this->app = require __DIR__ . '/../bootstrap/app.php';
        $this->factory = new Psr17Factory();
    }

    protected function tearDown(): void
    {
        foreach (array_keys(self::ENV) as $key) {
            putenv($key);
            unset($_ENV[$key]);
        }
    }

    /**
     * @param array<string, string> $headers
     * @param array<string, mixed>|null $json
     */
    private function request(string $method, string $uri, ?array $json = null, array $headers = []): ResponseInterface
    {
        $request = $this->factory->createServerRequest($method, $uri);
        foreach ($headers as $name => $value) {
            $request = $request->withHeader($name, $value);
        }
        if ($json !== null) {
            $request = $request
                ->withHeader('Content-Type', 'application/json')
                ->withBody($this->factory->createStream((string) json_encode($json)));
        }

        return $this->app->handle($request);
    }

    /**
     * @return array<string, mixed>
     */
    private static function body(ResponseInterface $response): array
    {
        $data = json_decode((string) $response->getBody(), true);

        return is_array($data) ? $data : [];
    }

    public function testWelcomeAndHealth(): void
    {
        $welcome = $this->request('GET', '/');
        $this->assertSame(200, $welcome->getStatusCode());
        $this->assertSame('PivotPHP ' . Application::VERSION, self::body($welcome)['framework']);

        $this->assertSame('healthy', self::body($this->request('GET', '/health'))['status']);
    }

    public function testStatusReadsConfiguration(): void
    {
        $body = self::body($this->request('GET', '/api/status'));

        $this->assertSame('PivotPHP Skeleton API', $body['name']);
        $this->assertSame('testing', $body['environment']);
    }

    public function testListAndShowUsers(): void
    {
        $this->assertSame(3, self::body($this->request('GET', '/api/users'))['total']);
        $this->assertSame('Jane Smith', self::body($this->request('GET', '/api/users/2'))['user']['name']);
        $this->assertSame(404, $this->request('GET', '/api/users/99')->getStatusCode());
        $this->assertSame(404, $this->request('GET', '/api/users/abc')->getStatusCode());
    }

    /**
     * SPEC-082: POST/PUT returned 500 because body() was treated as an array.
     */
    public function testCreateUser(): void
    {
        $response = $this->request('POST', '/api/users', ['name' => 'Ana', 'email' => 'ana@example.com']);

        $this->assertSame(201, $response->getStatusCode());
        $this->assertSame('/api/users/4', $response->getHeaderLine('Location'));
        $this->assertSame('Ana', self::body($response)['user']['name']);
    }

    public function testCreateUserValidation(): void
    {
        $response = $this->request('POST', '/api/users', ['name' => '', 'email' => 'not-an-email']);

        $this->assertSame(422, $response->getStatusCode());
        $this->assertArrayHasKey('name', self::body($response)['errors']);
        $this->assertArrayHasKey('email', self::body($response)['errors']);
    }

    public function testUpdateAndDeleteUser(): void
    {
        $updated = $this->request('PUT', '/api/users/1', ['name' => 'John Updated']);
        $this->assertSame(200, $updated->getStatusCode());
        $this->assertSame('John Updated', self::body($updated)['user']['name']);
        $this->assertSame('john@example.com', self::body($updated)['user']['email']);

        $this->assertSame(404, $this->request('PUT', '/api/users/99', ['name' => 'X'])->getStatusCode());

        $deleted = $this->request('DELETE', '/api/users/1');
        $this->assertSame(204, $deleted->getStatusCode());
        $this->assertSame('', (string) $deleted->getBody());
    }

    public function testMalformedJsonIsRejected(): void
    {
        $request = $this->factory->createServerRequest('POST', '/api/users')
            ->withHeader('Content-Type', 'application/json')
            ->withBody($this->factory->createStream('{invalid'));

        $this->assertSame(400, $this->app->handle($request)->getStatusCode());
    }

    public function testWrongMethodReturns405(): void
    {
        $response = $this->request('PATCH', '/api/users');

        $this->assertSame(405, $response->getStatusCode());
        $this->assertStringContainsString('GET', $response->getHeaderLine('Allow'));
    }

    /**
     * SPEC-084: debug is off by default — errors do not expose details.
     */
    public function testDebugIsOffByDefault(): void
    {
        $this->assertFalse($this->app->getConfig()->get('app.debug'));

        $body = self::body($this->request('GET', '/api/users/1/missing'));
        $this->assertArrayNotHasKey('trace', $body);
    }

    public function testCorsAllowsOnlyConfiguredOrigins(): void
    {
        $allowed = $this->request('OPTIONS', '/api/users', null, [
            'Origin' => self::ORIGIN,
            'Access-Control-Request-Method' => 'POST',
            'Access-Control-Request-Headers' => 'Content-Type',
        ]);
        $this->assertSame(204, $allowed->getStatusCode());
        $this->assertSame(self::ORIGIN, $allowed->getHeaderLine('Access-Control-Allow-Origin'));

        $denied = $this->request('GET', '/api/users', null, ['Origin' => 'https://evil.example']);
        $this->assertFalse($denied->hasHeader('Access-Control-Allow-Origin'));
    }
}
