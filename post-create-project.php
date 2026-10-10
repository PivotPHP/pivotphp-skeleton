<?php

declare(strict_types=1);

/**
 * Runs after `composer create-project`: creates .env from .env.example.
 */

$root = __DIR__;

if (!file_exists($root . '/.env') && file_exists($root . '/.env.example')) {
    copy($root . '/.env.example', $root . '/.env');
    echo "Created .env from .env.example\n";
}

echo <<<TXT

PivotPHP project ready.

  composer serve   # http://localhost:8000
  composer test    # run the tests

Endpoints: /  /health  /api/status  /api/users

TXT;
