# CLAUDE.md

This file provides guidance to Claude Code (claude.ai/code) when working with code in this repository.

## Repository Overview

This is the **PivotPHP Skeleton** - a project template for quickly creating APIs with PivotPHP v1.2.0. It's designed to be used with `composer create-project pivotphp/skeleton my-api` to bootstrap new PivotPHP applications.

### Purpose
- Provides a complete, ready-to-use API project template
- Demonstrates PivotPHP v1.2.0 features and best practices  
- Includes automatic OpenAPI/Swagger documentation
- Shows Express.js-style routing patterns
- Provides example CRUD controllers and middleware

### Target Version
- **PivotPHP Core**: v1.2.0 "Simplicity over Premature Optimization" edition
- **PHP**: ^8.1 (with PHP 8.4+ array callable support)
- **Focus**: Educational and rapid prototyping

## Project Structure

```
pivotphp-skeleton/
├── app/
│   ├── Controllers/          # Example API controllers
│   │   ├── ApiController.php # General API status controller
│   │   └── UserController.php # CRUD example controller
│   └── Middleware/           # Custom middleware examples
│       └── CorsMiddleware.php # CORS handling middleware
├── config/
│   └── app.php              # Application configuration
├── public/
│   └── index.php            # Application entry point
├── routes/
│   └── api.php              # API route definitions with OpenAPI docs
├── storage/
│   └── logs/                # Log storage directory
├── tests/
│   └── ApiTest.php          # Example PHPUnit tests
├── composer.json            # Package definition and scripts
├── phpunit.xml              # PHPUnit configuration
├── post-create-project.php  # Post-installation setup script
├── README.md                # User documentation
├── CHANGELOG.md             # Version history
├── LICENSE                  # MIT license
└── .gitignore              # Generated during setup
```

## Key Features Demonstrated

### 1. OpenAPI/Swagger Documentation
- Routes defined with PHPDoc annotations for automatic documentation
- Interactive Swagger UI available at `/swagger`
- OpenAPI 3.0 specification at `/openapi.json`

### 2. Express.js-Style Routing
- Familiar syntax: `$app->get('/', function($req, $res) {})`
- Array callable support: `$app->get('/users', [UserController::class, 'index'])`
- Route parameters: `$app->get('/users/{id}', ...)`

### 3. Complete CRUD Example
- Users API with full CRUD operations
- Proper HTTP status codes
- JSON responses with timestamps
- Input validation examples

### 4. Development Workflow
- `composer serve` for development server
- `composer test` for running PHPUnit tests
- Automatic project setup with post-create-project script

## Essential Commands

### For Users (After Creating Project)
```bash
# Create new project
composer create-project pivotphp/skeleton my-api

# Start development server
cd my-api && composer serve

# Run tests
composer test

# View API documentation
# Visit http://localhost:8000/swagger
```

### For Development (This Repository)
```bash
# Test the skeleton locally
composer install
php -S localhost:8000 -t public

# Run tests
composer test

# Validate structure
php post-create-project.php
```

## Configuration Notes

### composer.json
- **Type**: "project" (not "library") for composer create-project
- **Scripts**: Includes post-create-project-cmd hook
- **Dependencies**: Requires pivotphp/core ^1.2.0
- **Autoloading**: PSR-4 autoloading for App\ namespace

### Post-Create Setup
The `post-create-project.php` script automatically:
- Creates .env file with development defaults
- Creates .gitignore with appropriate exclusions
- Creates storage directories with proper permissions
- Displays quick start instructions to user

### Example Code Quality
- All PHP files use `declare(strict_types=1);`
- PSR-4 autoloading standards
- Comprehensive PHPDoc comments
- OpenAPI annotations for automatic documentation
- Proper HTTP status codes and error handling

## Development Guidelines

### When Updating This Skeleton
1. **Keep it Simple**: Focus on demonstrating PivotPHP features clearly
2. **Educational Value**: Code should teach best practices
3. **Real-World Examples**: Include practical, usable patterns
4. **Documentation**: Maintain comprehensive OpenAPI annotations
5. **Testing**: Include examples of how to test PivotPHP applications

### Version Compatibility
- Always target the latest PivotPHP version
- Update performance metrics when PivotPHP benchmarks change
- Ensure compatibility with minimum PHP version (8.1+)
- Test with PHP 8.4+ array callable features

### Common Tasks
- **Add New Controller**: Create in `app/Controllers/` with proper routes
- **Add Middleware**: Create in `app/Middleware/` with usage examples
- **Update Dependencies**: Modify composer.json and test thoroughly
- **Add Features**: Update README, tests, and documentation

## Performance Expectations

Based on PivotPHP v1.2.0 benchmarks:
- **HTTP Peak**: 2,122 req/sec (Docker validated)
- **HTTP Average**: 1,418 req/sec  
- **OpenAPI Generation**: 3.6M ops/sec
- **Memory Usage**: Efficient, educational focus maintained

## Important Notes

- This is a **project template**, not a library
- Designed for `composer create-project` workflow
- Focuses on **education and rapid prototyping**
- Includes **real performance data** from PivotPHP benchmarks
- Demonstrates **v1.2.0 simplicity philosophy**

## Related Documentation

- [PivotPHP Core](../pivotphp-core/CLAUDE.md) - Main framework
- [Website Documentation](../website/CLAUDE.md) - Public documentation
- [Benchmarks](../pivotphp-benchmarks/CLAUDE.md) - Performance testing

## Publishing Notes

This skeleton will be published to Packagist as `pivotphp/skeleton` to enable:
```bash
composer create-project pivotphp/skeleton my-api
```

The package should be tagged with semantic versions and maintain compatibility with PivotPHP core releases.