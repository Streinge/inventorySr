<?php

declare(strict_types=1);

namespace tests;

use PHPUnit\Framework\TestCase;
use src\config\ApiConfig;
use src\config\ConfigException;

require_once __DIR__ . '/../autoload.php';

class ApiConfigTest extends TestCase
{

    public function testEmptyApiPassException()
    {
        $this->expectException(ConfigException::class);
        new ApiConfig('');
    }


    public function testGetters()
    {
        $apiPass = 'apiPassword';

        $apiConfig = new ApiConfig($apiPass);

        $this->assertSame($apiPass, $apiConfig->getApiPassword());
    }



}

