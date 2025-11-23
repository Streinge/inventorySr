<?php

declare(strict_types=1);

namespace tests;

use PHPUnit\Framework\TestCase;
use src\apiActionTypes\ApiActionTypes;
use src\apiActionTypes\ApiActionTypesException;
use src\Path;

require_once __DIR__ . '/../autoload.php';

class ApiActionTypesTest extends TestCase
{

    public function testEmptyApiActionTypesException()
    {
        $this->expectException(ApiActionTypesException::class);
        (new ApiActionTypes(''))->getApiAction();
    }

    public function testValidApiAction()
    {

        $dirStocksGet = realpath(__DIR__ . DIRECTORY_SEPARATOR . '..' . DIRECTORY_SEPARATOR . Path::API_STOCKS_GET_DIRECTORY);
        $dirStocksCorrection = realpath(__DIR__ . DIRECTORY_SEPARATOR . '..' . DIRECTORY_SEPARATOR . Path::API_STOCKS_CORRECTION_DIRECTORY);

        $actionStocksGet = (new ApiActionTypes($dirStocksGet))->getApiAction();
        $actionStocksCorrection = (new ApiActionTypes($dirStocksCorrection))->getApiAction();

        $this->assertSame(ApiActionTypes::GET_STOCKS_ACTION, $actionStocksGet);
        $this->assertSame(ApiActionTypes::CORRECTION_STOCKS_ACTION, $actionStocksCorrection);
    }


}

