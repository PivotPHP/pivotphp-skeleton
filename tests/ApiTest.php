<?php

declare(strict_types=1);

namespace Tests;

use PHPUnit\Framework\TestCase;

/**
 * Basic API Tests
 * Example tests for the skeleton application
 */
class ApiTest extends TestCase
{
    /**
     * Test that we can run basic tests
     */
    public function testBasicAssertion(): void
    {
        $this->assertTrue(true);
        $this->assertEquals(4, 2 + 2);
    }

    /**
     * Test application configuration
     */
    public function testConfiguration(): void
    {
        $config = require __DIR__ . '/../config/app.php';
        
        $this->assertIsArray($config);
        $this->assertEquals('PivotPHP Skeleton API', $config['name']);
        $this->assertEquals('1.0.0', $config['version']);
        $this->assertEquals('PivotPHP', $config['framework']['name']);
        $this->assertEquals('1.2.0', $config['framework']['version']);
    }

    /**
     * Test that required directories exist
     */
    public function testDirectoryStructure(): void
    {
        $basePath = __DIR__ . '/..';
        
        $this->assertDirectoryExists($basePath . '/public');
        $this->assertDirectoryExists($basePath . '/app');
        $this->assertDirectoryExists($basePath . '/app/Controllers');
        $this->assertDirectoryExists($basePath . '/app/Middleware');
        $this->assertDirectoryExists($basePath . '/config');
        $this->assertDirectoryExists($basePath . '/routes');
        $this->assertDirectoryExists($basePath . '/storage');
        $this->assertDirectoryExists($basePath . '/storage/logs');
    }

    /**
     * Test that required files exist
     */
    public function testRequiredFiles(): void
    {
        $basePath = __DIR__ . '/..';
        
        $this->assertFileExists($basePath . '/public/index.php');
        $this->assertFileExists($basePath . '/routes/api.php');
        $this->assertFileExists($basePath . '/config/app.php');
        $this->assertFileExists($basePath . '/composer.json');
        $this->assertFileExists($basePath . '/README.md');
    }
}