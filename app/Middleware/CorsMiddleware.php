<?php

declare(strict_types=1);

namespace App\Middleware;

/**
 * CORS Middleware
 * Handles Cross-Origin Resource Sharing headers
 */
class CorsMiddleware
{
    /**
     * Handle CORS headers
     * 
     * @param mixed $req Request object
     * @param mixed $res Response object
     * @param callable $next Next middleware
     * @return mixed
     */
    public function __invoke($req, $res, $next)
    {
        // Set CORS headers
        $res->header('Access-Control-Allow-Origin', '*');
        $res->header('Access-Control-Allow-Methods', 'GET, POST, PUT, DELETE, OPTIONS');
        $res->header('Access-Control-Allow-Headers', 'Content-Type, Authorization, X-Requested-With');
        $res->header('Access-Control-Max-Age', '3600');

        // Handle preflight requests
        if ($req->getMethod() === 'OPTIONS') {
            return $res->status(200)->json(['message' => 'CORS preflight successful']);
        }

        return $next($req, $res);
    }
}