<?php

declare(strict_types=1);

namespace App\Controllers;

use PivotPHP\Http\ExpressRequest;
use PivotPHP\Http\ExpressResponse;
use Psr\Http\Message\ResponseInterface;

/**
 * Example CRUD controller.
 *
 * Data lives in memory: under PHP-FPM / the built-in server every request starts again from the
 * initial list. Replace the array with your persistence layer (e.g. PivotPHP\Core\Database\Database).
 */
final class UserController
{
    /** @var array<int, array{id: int, name: string, email: string}> */
    private array $users = [
        1 => ['id' => 1, 'name' => 'John Doe', 'email' => 'john@example.com'],
        2 => ['id' => 2, 'name' => 'Jane Smith', 'email' => 'jane@example.com'],
        3 => ['id' => 3, 'name' => 'Bob Johnson', 'email' => 'bob@example.com'],
    ];

    public function index(ExpressRequest $req, ExpressResponse $res): ResponseInterface
    {
        return $res->json(['users' => array_values($this->users), 'total' => count($this->users)]);
    }

    public function show(ExpressRequest $req, ExpressResponse $res): ResponseInterface
    {
        $user = $this->users[(int) $req->param('id')] ?? null;

        return $user === null ? $res->error(404, 'User not found') : $res->json(['user' => $user]);
    }

    public function store(ExpressRequest $req, ExpressResponse $res): ResponseInterface
    {
        $errors = $this->validate($req, requireAll: true);
        if ($errors !== []) {
            return $res->status(422)->json(['errors' => $errors]);
        }

        $user = [
            'id' => max(array_keys($this->users)) + 1,
            'name' => trim((string) $req->input('name')),
            'email' => (string) $req->input('email'),
        ];

        return $res->status(201)->header('Location', '/api/users/' . $user['id'])->json(['user' => $user]);
    }

    public function update(ExpressRequest $req, ExpressResponse $res): ResponseInterface
    {
        $id = (int) $req->param('id');
        $user = $this->users[$id] ?? null;
        if ($user === null) {
            return $res->error(404, 'User not found');
        }

        $errors = $this->validate($req, requireAll: false);
        if ($errors !== []) {
            return $res->status(422)->json(['errors' => $errors]);
        }

        $name = $req->input('name');
        $email = $req->input('email');
        $user['name'] = is_string($name) ? trim($name) : $user['name'];
        $user['email'] = is_string($email) ? $email : $user['email'];

        return $res->json(['user' => $user]);
    }

    public function destroy(ExpressRequest $req, ExpressResponse $res): ResponseInterface
    {
        return isset($this->users[(int) $req->param('id')])
            ? $res->noContent()
            : $res->error(404, 'User not found');
    }

    /**
     * @return array<string, string>
     */
    private function validate(ExpressRequest $req, bool $requireAll): array
    {
        $errors = [];
        $name = $req->input('name');
        $email = $req->input('email');

        if ($name !== null || $requireAll) {
            if (!is_string($name) || trim($name) === '') {
                $errors['name'] = 'The name field is required.';
            }
        }

        if ($email !== null || $requireAll) {
            if (!is_string($email) || filter_var($email, FILTER_VALIDATE_EMAIL) === false) {
                $errors['email'] = 'The email field must be a valid e-mail address.';
            }
        }

        return $errors;
    }
}
