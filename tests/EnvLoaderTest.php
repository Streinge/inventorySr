<?php

declare(strict_types=1);

namespace tests;

use PHPUnit\Framework\TestCase;
use src\env\EnvException;
use src\env\EnvLoader;

class EnvLoaderTest extends TestCase
{

    private string $validEnvFile;
    private string $invalidEnvFile;
    private string $emptyEnvFile;
    private string $missingFile;

    protected function setUp(): void
    {
        $basePath = __DIR__ . '/fixtures';

        $this->validEnvFile = $basePath . '/validEnv.php';
        $this->invalidEnvFile = $basePath . '/notArrayConfig.php';
        $this->emptyEnvFile = $basePath . '/emptyConfig.php';
        $this->missingFile = $basePath . '/missingConfig.php';
    }

    public function testLoadValidConfig()
    {
        $loader = new EnvLoader();
        $env = $loader->loadFromPhpFile($this->validEnvFile);


        $this->assertSame('production', $env->getAppEnvType());
        $this->assertSame('errors.txt', $env->getDefaultErrorFilename());
        $this->assertSame('https://prod.example.com/', $env->getSrApiUrl());
    }

    public function testLoadConfigFileNotFound()
    {
        $this->expectException(EnvException::class);
        $loader = new EnvLoader();
        $loader->loadFromPhpFile($this->missingFile);
    }

    public function testLoadNotArrayConfig()
    {
        $this->expectException(EnvException::class);
        $loader = new EnvLoader();
        $loader->loadFromPhpFile($this->invalidEnvFile);
    }

    public function testLoadEmptyConfig()
    {
        $this->expectException(EnvException::class);
        $loader = new EnvLoader();
        $loader->loadFromPhpFile($this->emptyEnvFile);
    }


}