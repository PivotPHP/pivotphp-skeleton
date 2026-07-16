# Changelog

All notable changes to the PivotPHP Skeleton project will be documented in this file.

The format is based on [Keep a Changelog](https://keepachangelog.com/en/1.0.0/),
and this project adheres to [Semantic Versioning](https://semver.org/spec/v2.0.0.html).

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

## [Unreleased]

### Planned
- Database integration examples
- Authentication middleware examples  
- Rate limiting middleware
- Caching examples
- Docker Compose setup
- Production deployment guides