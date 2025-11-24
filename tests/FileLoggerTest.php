<?php

declare(strict_types=1);

namespace tests;

use PHPUnit\Framework\TestCase;
use src\apiActionTypes\ApiActionTypes;
use src\env\Env;
use src\FileLogger;
use src\Path;

require_once __DIR__ . '/../autoload.php';

class FileLoggerTest extends TestCase
{
    private Env $mockEnv;
    private Path $mockPath;
    private string $logDir;

    protected function setUp(): void
    {
        $this->logDir = __DIR__ . DIRECTORY_SEPARATOR . 'test_logs';

        

        if (!is_dir($this->logDir)) {
            mkdir($this->logDir, 0777, true);
        }

        $this->mockEnv = $this->createMock(Env::class);
        $this->mockEnv->method('getDefaultErrorFilename')->willReturn('error.log');
        $this->mockPath = $this->createMock(Path::class);
        $this->mockPath->method('getApiLogsPath')->willReturn($this->logDir);

    }

    public function tearDown(): void
    {
        array_map('unlink', glob($this->logDir . DIRECTORY_SEPARATOR . "*"));
        rmdir($this->logDir);
    }

    public function testWriteGetStockLogCreatesFile()
    {
        $message = "Test get stock log message";


        
        $logger = new FileLogger($message, $this->mockEnv, $this->mockPath, ApiActionTypes::GET_STOCKS_ACTION);
        $logger->writeLog();

        $files = glob($this->logDir . DIRECTORY_SEPARATOR . FileLogger::LOG_STOCK_GET_FILENAME . '*');

        $this->assertNotEmpty($files, "Ожидался лог файл get stock");

        $content = file_get_contents($files[0]);
        $this->assertStringContainsString($message, $content);
    }

    public function testWriteCorrectionStockLogCreatesFile()
    {
        $message = "Test correction stock log message";
        $logger = new FileLogger($message, $this->mockEnv, $this->mockPath, ApiActionTypes::CORRECTION_STOCKS_ACTION);
        $logger->writeLog();

        $files = glob($this->logDir . DIRECTORY_SEPARATOR . FileLogger::LOG_STOCK_CORRECTION_FILENAME . '*');
        $this->assertNotEmpty($files, "Ожидался лог файл correction stock");

        $content = file_get_contents($files[0]);
        $this->assertStringContainsString($message, $content);
    }

    public function testWriteLogWithInvalidActionLogsError()
    {
        $invalidAction = 'invalidActionTest';
        $logger = new FileLogger("message", $this->mockEnv, $this->mockPath, $invalidAction);
        $logger->writeLog();

        $files = glob($this->logDir . DIRECTORY_SEPARATOR . $this->mockEnv->getDefaultErrorFilename() . '*');
        $this->assertNotEmpty($files, "Ожидался лог error.txt");
        $content = file_get_contents($files[0]);
        $this->assertStringContainsString("Logs do not write because api action has invalid value", $content);
    }

}

