<?php

declare(strict_types=1);

namespace App\Controllers;

/**
 * API Controller
 * Handles general API endpoints
 */
class ApiController
{
    /**
     * Get API status and metadata
     * 
     * @param mixed $req Request object
     * @param mixed $res Response object
     * @return mixed JSON response
     */
    public function status($req, $res)
    {
        return $res->json([
            'api' => [
                'name' => 'PivotPHP Skeleton API',
                'version' => '1.0.0',
                'framework' => 'PivotPHP v2.2.0',
                'edition' => 'Route Syntax & DX Edition'
            ],
            'features' => [
                'automatic_openapi' => true,
                'swagger_ui' => '/swagger',
                'openapi_spec' => '/openapi.json',
                'express_syntax' => true,
                'array_callables' => true
            ],
            'performance' => [
                'http_peak_rps' => 2122,
                'openapi_ops_sec' => '3.6M',
                'docker_validated' => true
            ],
            'endpoints' => [
                'welcome' => '/',
                'health' => '/health',
                'api_status' => '/api/status',
                'users' => '/api/users',
                'documentation' => '/swagger'
            ],
            'timestamp' => date('c'),
            'server_time' => time()
        ]);
    }
}