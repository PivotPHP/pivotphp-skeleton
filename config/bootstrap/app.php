<?php

declare(strict_types=1);

/**
 * Builds the application. Used by public/index.php (HTTP) and by the tests.
 *
 * Keep this file in config/bootstrap/: the core loads every config/*.php (one level, no
 * subdirectories) as a configuration file, so a script directly in config/ would be executed
 * while the Application is being built.
 *
 * Boot order: boot() loads .env and config/ first, so the configuration is available
 * when middlewares and routes are registered.
 */

use App\Controllers\ApiController;
use PivotPHP\Core\Core\Application;
use PivotPHP\Http\Factory\Psr17Factory;
use PivotPHP\Security\Cors\CorsConfig;
use PivotPHP\Security\Cors\CorsMiddleware;

require_once __DIR__ . '/../../vendor/autoload.php';

$app = Application::create(dirname(__DIR__, 2));
$app->boot();

$config = $app->getConfig();

// CORS: only the origins listed in CORS_ALLOWED_ORIGINS (comma-separated). Empty = no CORS headers.
$origins = $config->get('app.cors.allowed_origins', []);
$app->use(new CorsMiddleware(new Psr17Factory(), new CorsConfig(
    allowedOrigins: is_array($origins) ? array_values(array_filter($origins, 'is_string')) : [],
)));

// Controllers with constructor dependencies are registered in the container; controllers without
// dependencies are instantiated directly.
$app->singleton(ApiController::class, fn () => new ApiController($app));

require __DIR__ . '/../../src/Routers/api.php';

return $app;
