<?php

declare(strict_types=1);

/**
 * API routes. $app is the PivotPHP\Core\Core\Application built in config/bootstrap/app.php.
 *
 * Handlers receive PivotPHP\Http\ExpressRequest ($req) and ExpressResponse ($res) and must
 * return the response.
 */

use App\Controllers\ApiController;
use App\Controllers\UserController;
use PivotPHP\Core\Core\Application;

/** @var Application $app */

$app->get('/', fn ($req, $res) => $res->json([
    'message' => 'Welcome to your PivotPHP API',
    'framework' => 'PivotPHP ' . Application::VERSION,
    'endpoints' => ['/health', '/api/status', '/api/users'],
]));

$app->get('/health', fn ($req, $res) => $res->json([
    'status' => 'healthy',
    'timestamp' => date('c'),
]));

$app->get('/api/status', [ApiController::class, 'status']);

$app->get('/api/users', [UserController::class, 'index']);
$app->post('/api/users', [UserController::class, 'store']);
$app->get('/api/users/:id<\d+>', [UserController::class, 'show']);
$app->put('/api/users/:id<\d+>', [UserController::class, 'update']);
$app->delete('/api/users/:id<\d+>', [UserController::class, 'destroy']);
