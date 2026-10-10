<?php

declare(strict_types=1);

namespace Tests;

use PHPUnit\Framework\TestCase;

/**
 * The core loads every config/*.php (one level) as a configuration file. A script placed there
 * (e.g. the bootstrap) would run while the Application is being built — keep scripts in
 * subdirectories such as config/bootstrap/.
 */
final class ConfigLayoutTest extends TestCase
{
    public function testEveryTopLevelConfigFileReturnsAnArray(): void
    {
        $files = glob(dirname(__DIR__) . '/config/*.php');
        $this->assertNotEmpty($files);

        foreach ($files as $file) {
            // Checked before require: a bootstrap script here would build the app recursively.
            $source = (string) file_get_contents($file);
            $this->assertDoesNotMatchRegularExpression(
                '/Application::create|new\s+Application\b|vendor\/autoload\.php/',
                $source,
                basename($file) . ' looks like a script; move it to a subdirectory (e.g. config/bootstrap/)'
            );

            $value = (static fn (string $path): mixed => require $path)($file);
            $this->assertIsArray($value, basename($file) . ' must return a configuration array');
        }
    }

    public function testBootstrapLivesInASubdirectory(): void
    {
        $this->assertFileExists(dirname(__DIR__) . '/config/bootstrap/app.php');
        $this->assertFileDoesNotExist(dirname(__DIR__) . '/config/bootstrap.php');
    }
}
