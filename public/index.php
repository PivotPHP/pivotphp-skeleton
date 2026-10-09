<?php

declare(strict_types=1);

/**
 * PivotPHP v2.2.0 Skeleton Application
 * Entry point for your new API project
 */

require_once __DIR__ . '/../vendor/autoload.php';

use PivotPHP\Core\Core\Application;

// Create PivotPHP application
$app = Application::create();

// Load application routes
require_once __DIR__ . '/../routes/api.php';

// Run the application
$app->run();