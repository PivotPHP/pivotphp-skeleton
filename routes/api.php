<?php

declare(strict_types=1);

/**
 * API Routes for PivotPHP v1.2.0 Skeleton
 * Define your API endpoints here
 */

use App\Controllers\ApiController;
use App\Controllers\UserController;

/**
 * Welcome endpoint
 * @route GET /
 * @summary Welcome message for the API
 * @tags Welcome
 * @response 200 Welcome message
 */
$app->get('/', function($req, $res) {
    return $res->json([
        'message' => 'Welcome to PivotPHP v1.2.0!',
        'framework' => 'PivotPHP',
        'version' => '1.2.0',
        'edition' => 'Simplicity over Premature Optimization',
        'features' => [
            'automatic_openapi_docs' => '/swagger',
            'openapi_spec' => '/openapi.json',
            'health_check' => '/health'
        ],
        'performance' => [
            'http_peak_rps' => 2122,
            'http_average_rps' => 1418,
            'openapi_generation_ops' => '3.6M',
            'docker_validated' => true
        ],
        'timestamp' => date('c')
    ]);
});

/**
 * Health check endpoint
 * @route GET /health
 * @summary Health check for monitoring
 * @tags Health
 * @response 200 Health status
 */
$app->get('/health', function($req, $res) {
    return $res->json([
        'status' => 'healthy',
        'framework' => 'PivotPHP v1.2.0',
        'timestamp' => date('c'),
        'uptime' => 'ready',
        'features' => [
            'openapi' => 'enabled',
            'swagger_ui' => 'available'
        ]
    ]);
});

/**
 * API status endpoint
 * @route GET /api/status
 * @summary API status and metadata
 * @tags API
 * @response 200 API status information
 */
$app->get('/api/status', [ApiController::class, 'status']);

/**
 * Users endpoints
 * @route GET /api/users
 * @summary List all users
 * @tags Users
 * @response 200 List of users
 */
$app->get('/api/users', [UserController::class, 'index']);

/**
 * @route GET /api/users/{id}
 * @summary Get user by ID
 * @tags Users
 * @parameter {integer} id.path.required - User ID
 * @response 200 User details
 * @response 404 User not found
 */
$app->get('/api/users/{id}', [UserController::class, 'show']);

/**
 * @route POST /api/users
 * @summary Create new user
 * @tags Users
 * @parameter {object} body.body.required - User data
 * @response 201 User created successfully
 * @response 400 Invalid input
 */
$app->post('/api/users', [UserController::class, 'store']);

/**
 * @route PUT /api/users/{id}
 * @summary Update user
 * @tags Users
 * @parameter {integer} id.path.required - User ID
 * @parameter {object} body.body.required - Updated user data
 * @response 200 User updated successfully
 * @response 404 User not found
 */
$app->put('/api/users/{id}', [UserController::class, 'update']);

/**
 * @route DELETE /api/users/{id}
 * @summary Delete user
 * @tags Users
 * @parameter {integer} id.path.required - User ID
 * @response 204 User deleted successfully
 * @response 404 User not found
 */
$app->delete('/api/users/{id}', [UserController::class, 'destroy']);

/**
 * Example error endpoint for testing
 * @route GET /api/error
 * @summary Trigger example error
 * @tags Testing
 * @response 500 Example error response
 */
$app->get('/api/error', function($req, $res) {
    throw new \Exception('This is an example error for testing purposes');
});