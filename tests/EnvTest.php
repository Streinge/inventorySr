<?php

declare(strict_types=1);

namespace tests;

use PHPUnit\Framework\TestCase;
use src\config\ApiConfig;
use src\config\ConfigException;
use src\env\Env;
use src\env\EnvException;

require_once __DIR__ . '/../autoload.php';

class EnvTest extends TestCase
{

    public function testInvalidAppTypeException()
    {
        $this->expectException(EnvException::class);
        new Env('invalidType', 'errFile.txt', 'https://example.ru');
    }

    public function testEmptyServerUrlException()
    {
        $this->expectException(EnvException::class);
        new Env('production', 'errFile.txt', '');
    }

    public function testConstructorsAndGetters()
    {
        $productionEnv = new Env('production', 'errFile.txt', 'https://example.ru');
        $this->assertSame('production', $productionEnv->getAppEnvType());
        $this->assertSame('errFile.txt', $productionEnv->getDefaultErrorFilename());
        $this->assertSame('https://example.ru', $productionEnv->getSrApiUrl());

        $developmentEnv = new Env('development', '', 'https://example.ru');
        $this->assertSame('development', $developmentEnv->getAppEnvType());
        $this->assertSame('error.txt', $developmentEnv->getDefaultErrorFilename());

    }


}

