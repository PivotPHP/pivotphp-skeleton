<?php

declare(strict_types=1);

/**
 * Application Configuration
 * Configure your PivotPHP application settings
 */

return [
    // Application settings
    'name' => 'PivotPHP Skeleton API',
    'version' => '1.0.0',
    'env' => $_ENV['APP_ENV'] ?? 'development',
    'debug' => (bool) ($_ENV['APP_DEBUG'] ?? true),
    
    // Framework settings
    'framework' => [
        'name' => 'PivotPHP',
        'version' => '1.2.0',
        'edition' => 'Simplicity over Premature Optimization'
    ],
    
    // OpenAPI/Swagger settings
    'openapi' => [
        'enabled' => true,
        'title' => 'PivotPHP Skeleton API',
        'description' => 'Example API built with PivotPHP v1.2.0 skeleton',
        'version' => '1.0.0',
        'contact' => [
            'name' => 'API Support',
            'email' => 'support@example.com'
        ],
        'servers' => [
            [
                'url' => 'http://localhost:8000',
                'description' => 'Development server'
            ]
        ]
    ],
    
    // Performance settings
    'performance' => [
        'cache_routes' => false, // Enable in production
        'optimize_responses' => true,
        'enable_compression' => false // Enable in production
    ],
    
    // Security settings
    'security' => [
        'cors_enabled' => true,
        'rate_limiting' => false, // Enable in production
        'secure_headers' => false // Enable in production
    ],
    
    // Logging settings
    'logging' => [
        'enabled' => true,
        'level' => 'debug',
        'file' => __DIR__ . '/../storage/logs/app.log'
    ]
];