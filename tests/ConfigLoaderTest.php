<?php

declare(strict_types=1);

namespace tests;

use PHPUnit\Framework\TestCase;
use src\config\ConfigLoader;
use src\config\ConfigException;
use src\config\Config;
use src\config\CompanyCredentials;
use src\config\ApiConfig;

class ConfigLoaderTest extends TestCase
{

    private string $validConfigFile;
    private string $invalidConfigFile;
    private string $emptyConfigFile;
    private string $missingFile;

    protected function setUp(): void
    {
        $basePath = __DIR__ . '/fixtures';

        $this->validConfigFile = $basePath . '/validConfig.php';
        $this->invalidConfigFile = $basePath . '/notArrayConfig.php';
        $this->emptyConfigFile = $basePath . '/emptyConfig.php';
        $this->missingFile = $basePath . '/missingConfig.php';
    }

    public function testLoadValidConfig()
    {
        $loader = new ConfigLoader();
        $config = $loader->loadFromPhpFile($this->validConfigFile);

        $this->assertInstanceOf(Config::class, $config);
        $this->assertInstanceOf(CompanyCredentials::class, $config->getCompanyConfig());
        $this->assertInstanceOf(ApiConfig::class, $config->getApiConfig());

        $this->assertSame(123, $config->getCompanyConfig()->getCompanyId());
        $this->assertSame('token123', $config->getCompanyConfig()->getCompanyToken());
        $this->assertSame('examplePassword', $config->getApiConfig()->getApiPassword());
    }

    public function testLoadConfigFileNotFound()
    {
        $this->expectException(ConfigException::class);
        $loader = new ConfigLoader();
        $loader->loadFromPhpFile($this->missingFile);
    }

    public function testLoadNotArrayConfig()
    {
        $this->expectException(ConfigException::class);
        $loader = new ConfigLoader();
        $loader->loadFromPhpFile($this->invalidConfigFile);
    }

    public function testLoadEmptyConfig()
    {
        $this->expectException(ConfigException::class);
        $loader = new ConfigLoader();
        $loader->loadFromPhpFile($this->emptyConfigFile);
    }


}