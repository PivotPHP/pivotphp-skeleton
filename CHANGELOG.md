# Changelog

All notable changes to the PivotPHP Skeleton project will be documented in this file.

The format is based on [Keep a Changelog](https://keepachangelog.com/en/1.0.0/),
and this project adheres to [Semantic Versioning](https://semver.org/spec/v2.0.0.html).

## [2.0.2] - 2026-10-10

### Changed

- Requires `pivotphp/core: ^4.1.0` (was `^4.0.1`). No template/API changes — the framework
  version is reported dynamically via `Application::VERSION`.

## [2.0.1] - 2026-10-10

### Fixed

- Tests no longer depend on the project's `.env`: they set `APP_ENV=testing`, `APP_DEBUG=false` and
  `CORS_ALLOWED_ORIGINS` as real environment variables (which take precedence over `.env`). In a project
  created with `create-project`, `testStatusReadsConfiguration` failed because `.env` sets
  `APP_ENV=development`.

## [2.0.0] - 2026-10-10

Template for the PivotPHP 4 ecosystem (SPEC-089).

### Changed

- Requires **`pivotphp/core` ^4.0.1** (brings `pivotphp/http`, `pivotphp/core-routing` ^2.2 and
  `pivotphp/security`); `composer create-project` installs again (SPEC-098).
- Controllers use `ExpressRequest`/`ExpressResponse` (`$req->input()`, `$req->param()`) and return
  proper status codes: `201` + `Location`, `204` without body, `404`, `422` with field errors.
- New `bootstrap/app.php` builds the application for both `public/index.php` and the tests.
- `config/app.php` is loaded (application created with its base path) and reads the environment;
  `.env` is copied from `.env.example` on `create-project`.
- CORS via `pivotphp/security` `CorsMiddleware`, restricted to `CORS_ALLOWED_ORIGINS`.

### Fixed

- `POST`/`PUT /api/users` returned 500 (`body()` treated as an array) (SPEC-082).
- `config/` was never loaded, and debug defaulted to **on** when `APP_DEBUG` was unset, exposing stack
  traces (SPEC-084). Debug is now off unless `APP_DEBUG=true`.
- Tests depended on `storage/` (created only by `create-project`) and on a hard-coded framework version
  (SPEC-083).

### Removed

- `App\Middleware\CorsMiddleware` (wildcard origin, preflight answered with 200 and a JSON body).
- Unused configuration keys (`openapi`, `performance`, `security`, `logging`), the `storage/` layout and
  hard-coded framework versions and performance figures.

## [1.1.1] - 2026-10-09

### Fixed
- Removed misleading claims that `/swagger` and `/openapi.json` are available (they are
  opt-in and require `ApiDocumentationMiddleware`, not registered by default).
- Clarified `cd <project>` in the create-project Quick Start.

## [1.1.0] - 2026-10-08

### Changed
- Target **PivotPHP Core v2.2.0** (`pivotphp/core: ^2.2`) — brace route parameters
  (`{id}`), array callables with instance methods, and `Request::body()` now work.
- Update all framework version references (config, routes, controllers, README).

### Fixed
- `public/index.php` used the non-existent `PivotPHP\Core\Application` class — now
  uses the canonical `PivotPHP\Core\Core\Application`.

## [1.0.0] - 2025-07-21

### Added
- Initial release of PivotPHP Skeleton
- Support for PivotPHP v1.2.0 "Simplicity over Premature Optimization" edition
- Automatic OpenAPI/Swagger documentation generation
- Express.js-style routing patterns
- Complete CRUD API example with Users endpoints
- Built-in CORS middleware
- PHPUnit testing setup
- Post-create-project automation script
- Comprehensive README with quick start guide
- Example controllers and middleware
- Configuration management
- Development server integration

### Features
- 📚 Optional OpenAPI 3.0 documentation at `/swagger` — requires registering `ApiDocumentationMiddleware` in `public/index.php`, not enabled by default
- 🚀 Express.js syntax for familiar development experience
- 🎯 Array callable support (works from PHP 8.1+; the legacy `'Controller@method'` string syntax is what breaks under PHP 8.4+, not array callables)
- ✅ Complete testing setup with PHPUnit
- 🔧 Built-in development server (`composer serve`)
- 🏗️ MVC project structure
- 🌐 `CorsMiddleware` example class included in `app/Middleware/` — not registered by default, opt-in
- 📈 Performance optimizations included

### Performance
- HTTP Peak: 2,122 req/sec (Docker validated)
- HTTP Average: 1,418 req/sec
- OpenAPI Generation: 3.6M ops/sec
- Framework: PivotPHP v1.2.0 with educational focus

### Documentation
- Complete API documentation with examples
- Interactive Swagger UI interface
- Development workflow guidelines
- Testing examples and best practices
- Configuration options reference
