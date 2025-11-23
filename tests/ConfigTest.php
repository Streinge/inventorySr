<?php

declare(strict_types=1);

namespace tests;

use PHPUnit\Framework\TestCase;
use src\config\Config;
use src\config\CompanyCredentials;
use src\config\ApiConfig;

require_once __DIR__ . '/../autoload.php';
class ConfigTest extends TestCase
{
    public function testConstructorAndGetters()
    {
        $companyCredentials = new CompanyCredentials(123, 'token123');
        $apiConfig = new ApiConfig('scriptPassword');

        $config = new Config($companyCredentials, $apiConfig);

        $this->assertSame($companyCredentials, $config->getCompanyConfig());
        $this->assertSame($apiConfig, $config->getApiConfig());
    }
}

