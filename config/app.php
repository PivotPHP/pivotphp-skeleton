<?php

declare(strict_types=1);

/**
 * Application configuration (available as app.* via $app->getConfig()).
 * Values come from the environment / .env, with safe defaults.
 */

$env = static fn (string $key, ?string $default = null): ?string =>
    is_string($_ENV[$key] ?? null) ? $_ENV[$key] : (getenv($key) !== false ? (string) getenv($key) : $default);

return [
    'name' => $env('APP_NAME', 'PivotPHP Skeleton API'),
    'env' => $env('APP_ENV', 'production'),

    // Debug responses include exception messages and stack traces: off unless explicitly enabled.
    'debug' => filter_var($env('APP_DEBUG', 'false'), FILTER_VALIDATE_BOOL),

    'cors' => [
        'allowed_origins' => array_values(array_filter(array_map(
            'trim',
            explode(',', (string) $env('CORS_ALLOWED_ORIGINS', ''))
        ))),
    ],
];
