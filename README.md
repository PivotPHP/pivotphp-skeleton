# PivotPHP Skeleton

Project template for [PivotPHP](https://github.com/PivotPHP/pivotphp-core) 5 — an Express.js-style PHP
API on PSR-7/PSR-15.

## Quick start

```bash
composer create-project pivotphp/skeleton my-api
cd my-api
composer serve            # http://localhost:8000
```

`create-project` copies `.env.example` to `.env`. Requires PHP 8.1+ with `ext-mbstring`.

## Endpoints

| Method | Path | Description |
|---|---|---|
| GET | `/` | Welcome message |
| GET | `/health` | Health check |
| GET | `/api/status` | Name, environment and framework version (from `config/app.php`) |
| GET | `/api/users` | List users |
| POST | `/api/users` | Create a user (`name`, `email`; JSON or form) — `201` + `Location`, `422` on invalid data |
| GET | `/api/users/:id` | Show a user — `404` if missing |
| PUT | `/api/users/:id` | Update `name`/`email` |
| DELETE | `/api/users/:id` | Delete — `204` |

The example users live in memory, so every request starts from the same three users. Replace the array
in `UserController` with your persistence layer.

## Structure

```
config/
    app.php              app.* configuration, read from the environment
    bootstrap/app.php    builds the application: config, middlewares, controllers, routes
public/index.php         HTTP entry point
src/
    Controllers/         ApiController (container-injected), UserController (CRUD example)
    Routers/api.php      routes
tests/ApiTest.php        tests through the real application ($app->handle())
```

Every `config/*.php` is loaded by the core as a configuration file (returning an array). Scripts such
as the bootstrap live in a subdirectory (`config/bootstrap/`), which the core does not scan.

## Configuration

`.env` is loaded before `config/`; real environment variables take precedence.

| Variable | Default | Purpose |
|---|---|---|
| `APP_NAME` | `PivotPHP Skeleton API` | Application name |
| `APP_ENV` | `production` | Environment name |
| `APP_DEBUG` | `false` | Error responses with messages and stack traces — **never enable in production** |
| `CORS_ALLOWED_ORIGINS` | *(empty)* | Comma-separated origins allowed by CORS; empty disables CORS headers |

## Writing routes

```php
// src/Routers/api.php
$app->get('/hello/:name', fn ($req, $res) => $res->json(['hello' => $req->param('name')]));

$app->post('/items', function ($req, $res) {
    $name = $req->input('name');            // JSON or form body
    return $res->status(201)->json(['name' => $name]);
});
```

Handlers receive `PivotPHP\Http\ExpressRequest`/`ExpressResponse` and must return the response.
Controllers are array callables (`[UserController::class, 'index']`); register controllers that need
constructor dependencies in the container (see `config/bootstrap/app.php`).

Security middlewares (CORS, security headers, JWT, CSRF, rate limiting) come from
[`pivotphp/security`](https://github.com/PivotPHP/pivotphp-security); this template enables CORS.

## Commands

```bash
composer serve   # built-in server on localhost:8000 (docroot: public/)
composer test    # PHPUnit
```

## License

MIT
