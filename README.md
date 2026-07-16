# PivotPHP Skeleton

**The fastest way to start building APIs with PivotPHP v1.2.0**

[![PivotPHP](https://img.shields.io/badge/PivotPHP-v1.2.0-blue.svg)](https://github.com/PivotPHP/pivotphp-core)
[![PHP Version](https://img.shields.io/badge/PHP-^8.1-777BB4.svg)](https://php.net)
[![License](https://img.shields.io/badge/License-MIT-green.svg)](LICENSE)

> 🚀 **"Simplicity over Premature Optimization"** - PivotPHP v1.2.0 Edition

## ✨ What's Included

This skeleton provides everything you need to start building modern PHP APIs:

- 🎯 **PivotPHP v1.2.0** - Latest framework with educational focus
- 📚 **Optional OpenAPI/Swagger** - Interactive API documentation at `/swagger`, opt-in (a few lines in `public/index.php` — see [Enabling API Documentation](#enabling-api-documentation-optional) below)
- 🚀 **Express.js Syntax** - Familiar, intuitive routing patterns
- 🏗️ **MVC Structure** - Controllers, middleware, and clean organization
- ✅ **PHPUnit Testing** - Ready-to-use testing setup
- 🔧 **Development Tools** - Built-in server, debugging, and more

## 🚀 Quick Start

```bash
# Create a new project
composer create-project pivotphp/skeleton my-api

# Enter project directory and start server
cd my-api && composer serve
```

Your API is now running at **http://localhost:8000**! 🎉

## 📖 Available Endpoints

Once running, you can access:

| Endpoint | Description |
|----------|-------------|
| `GET /` | Welcome message with API info |
| `GET /health` | Health check endpoint |
| `GET /api/status` | API status and metadata |
| `GET /api/users` | List all users (CRUD example) |
| `POST /api/users` | Create new user |
| `GET /api/users/{id}` | Get user by ID |
| `PUT /api/users/{id}` | Update user |
| `DELETE /api/users/{id}` | Delete user |

`GET /swagger` and `GET /docs` (interactive API documentation and its OpenAPI 3.0 JSON spec) are **not** available out of the box — they require enabling `ApiDocumentationMiddleware` first. See [Enabling API Documentation](#enabling-api-documentation-optional) below.

## 🏗️ Project Structure

```
my-api/
├── app/
│   ├── Controllers/          # API controllers
│   │   ├── ApiController.php
│   │   └── UserController.php
│   └── Middleware/           # Custom middleware
│       └── CorsMiddleware.php
├── config/
│   └── app.php              # Application configuration
├── public/
│   └── index.php            # Application entry point
├── routes/
│   └── api.php              # API route definitions
├── storage/
│   └── logs/                # Application logs
├── tests/
│   └── ApiTest.php          # Example tests
├── .env                     # Environment configuration
├── composer.json            # Dependencies and scripts
└── README.md               # This file
```

## 🛠️ Development Commands

```bash
# Start development server
composer serve

# Run tests
composer test

# Run tests with coverage report
composer test:coverage
```

## 📚 Enabling API Documentation (optional)

The `@route`, `@summary`, `@tags` and `@response` PHPDoc comments you'll see above
each route in `routes/api.php` are for human readers only — `pivotphp/core` does
not parse them, and this skeleton does not register anything that would. By
default, **`/swagger` and `/docs` are not available**.

To enable them, register `PivotPHP\Core\Middleware\Http\ApiDocumentationMiddleware`
in `public/index.php`, before `$app->run()`:

```php
use PivotPHP\Core\Middleware\Http\ApiDocumentationMiddleware;

$app->use(new ApiDocumentationMiddleware([
    'docs_path' => '/docs',       // JSON OpenAPI 3.0 spec (note: not /openapi.json)
    'swagger_path' => '/swagger', // Swagger UI
]));
```

Once registered, the middleware builds the OpenAPI spec from the routes actually
registered on the `Router` at runtime — the PHPDoc blocks above are not read by it,
they are purely documentation for developers browsing `routes/api.php`.

After adding this, visit **http://localhost:8000/swagger** to see interactive API docs.

## 🎯 Express.js-Style Routing

Write routes that feel familiar:

```php
// Simple route
$app->get('/', function($req, $res) {
    return $res->json(['message' => 'Hello World!']);
});

// Route parameters
$app->get('/users/{id}', function($req, $res) {
    $id = $req->param('id');
    return $res->json(['user_id' => $id]);
});

// Array callables (work from PHP 8.1+; the legacy 'Controller@method' string
// syntax is what breaks under PHP 8.4+, not array callables themselves)
$app->post('/users', [UserController::class, 'store']);

// Middleware — CorsMiddleware ships as an example class in
// app/Middleware/CorsMiddleware.php but is NOT registered anywhere by
// default. Register it yourself in public/index.php before $app->run():
$app->use(new CorsMiddleware());
```

## 🔧 Configuration

Edit `config/app.php` to customize your application:

```php
return [
    'name' => 'My Awesome API',
    'openapi' => [
        'title' => 'My API Documentation',
        'version' => '2.0.0'
    ],
    'performance' => [
        'cache_routes' => true,  // Enable in production
        'optimize_responses' => true
    ]
];
```

## 🧪 Testing

Write tests in the `tests/` directory:

```php
class MyApiTest extends TestCase
{
    public function testWelcomeEndpoint(): void
    {
        // Your API tests here
        $this->assertTrue(true);
    }
}
```

## 📈 Performance

Historical PivotPHP v1.2.0 benchmark figures (Docker-validated at the time), not
revalidated against this skeleton or the current `pivotphp/core` release line —
treat as indicative, not a guarantee:

- **2,122 req/sec** peak HTTP performance
- **3.6M ops/sec** OpenAPI generation
- **Docker validated** benchmarks (as of the v1.2.0 release)

## 🚀 Next Steps

1. **Customize your API** - Edit routes in `routes/api.php`
2. **Add controllers** - Create new controllers in `app/Controllers/`
3. **Build middleware** - Add custom middleware in `app/Middleware/`
4. **Write tests** - Add tests in `tests/`
5. **Deploy** - Use your preferred deployment method

## 📖 Learn More

- [PivotPHP Documentation](https://pivotphp.github.io/website/)
- [GitHub Repository](https://github.com/PivotPHP/pivotphp-core)
- [Performance Benchmarks](https://pivotphp.github.io/website/docs/benchmarks/)

## 📄 License

The PivotPHP Skeleton is open-sourced software licensed under the [MIT license](LICENSE).

---

**Built with ❤️ by the PivotPHP Team**

*"Making PHP development joyful again"*
