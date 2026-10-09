<?php

declare(strict_types=1);

/**
 * Post Create Project Script
 * Runs after composer create-project to setup the skeleton
 */

echo "\n🚀 Setting up your PivotPHP v2.2.0 project...\n\n";

// Get current directory
$currentDir = getcwd();

// Create .env file if it doesn't exist
if (!file_exists($currentDir . '/.env')) {
    echo "📝 Creating .env file...\n";
    
    $envContent = <<<ENV
# PivotPHP Skeleton Environment
APP_NAME="PivotPHP Skeleton API"
APP_ENV=development
APP_DEBUG=true
APP_URL=http://localhost:8000

# OpenAPI/Swagger
OPENAPI_ENABLED=true
SWAGGER_UI_ENABLED=true

# Performance
CACHE_ROUTES=false
OPTIMIZE_RESPONSES=true

# Security  
CORS_ENABLED=true
RATE_LIMITING=false
SECURE_HEADERS=false

# Logging
LOG_LEVEL=debug
ENV;

    file_put_contents($currentDir . '/.env', $envContent);
    echo "✅ .env file created\n";
}

// Create .gitignore file
echo "📝 Creating .gitignore file...\n";

$gitignoreContent = <<<GITIGNORE
# Dependencies
/vendor/
composer.lock

# Environment
.env
.env.local
.env.production

# Logs
/storage/logs/*.log
/logs/
*.log

# Cache
/storage/cache/
/cache/

# IDE
.vscode/
.idea/
*.swp
*.swo

# OS
.DS_Store
Thumbs.db

# Testing
/coverage/
.phpunit.result.cache

# Build
/dist/
/build/
GITIGNORE;

file_put_contents($currentDir . '/.gitignore', $gitignoreContent);
echo "✅ .gitignore file created\n";

// Create storage directories and files
echo "📁 Creating storage structure...\n";

$directories = [
    'storage/logs',
    'storage/cache',
    'storage/tmp'
];

foreach ($directories as $dir) {
    $fullPath = $currentDir . '/' . $dir;
    if (!is_dir($fullPath)) {
        mkdir($fullPath, 0755, true);
        echo "  ✅ Created directory: {$dir}\n";
    }
}

// Create empty log file
$logFile = $currentDir . '/storage/logs/app.log';
if (!file_exists($logFile)) {
    file_put_contents($logFile, '');
    echo "  ✅ Created log file: storage/logs/app.log\n";
}

echo "\n🎉 PivotPHP Skeleton setup complete!\n\n";

echo "🚀 Quick Start:\n";
echo "  cd " . basename(getcwd()) . "\n";
echo "  composer serve     # Start development server\n";
echo "  composer test      # Run tests\n";
echo "\n";

echo "📖 Your API endpoints:\n";
echo "  http://localhost:8000/          # Welcome message\n";
echo "  http://localhost:8000/health    # Health check\n";
echo "  http://localhost:8000/swagger   # Interactive API docs\n";
echo "  http://localhost:8000/api/users # Users CRUD API\n";
echo "\n";

echo "🔧 Features available:\n";
echo "  ✅ Automatic OpenAPI/Swagger documentation\n";
echo "  ✅ Express.js-style routing syntax\n";
echo "  ✅ Array callable support (PHP 8.1+)\n";
echo "  ✅ Built-in CORS middleware\n";
echo "  ✅ Example CRUD controllers\n";
echo "  ✅ PHPUnit testing setup\n";
echo "\n";

echo "Happy coding with PivotPHP v2.2.0! 🎯\n\n";