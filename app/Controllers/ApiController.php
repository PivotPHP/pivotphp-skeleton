<?php

declare(strict_types=1);

namespace App\Controllers;

use PivotPHP\Core\Core\Application;
use PivotPHP\Http\ExpressRequest;
use PivotPHP\Http\ExpressResponse;
use Psr\Http\Message\ResponseInterface;

final class ApiController
{
    public function __construct(private readonly Application $app)
    {
    }

    public function status(ExpressRequest $req, ExpressResponse $res): ResponseInterface
    {
        $config = $this->app->getConfig();

        return $res->json([
            'name' => $config->get('app.name'),
            'environment' => $config->get('app.env'),
            'framework' => 'PivotPHP ' . Application::VERSION,
            'php' => PHP_VERSION,
            'timestamp' => date('c'),
        ]);
    }
}
