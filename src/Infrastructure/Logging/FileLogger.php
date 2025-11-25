<?php

declare(strict_types=1);

namespace src\Infrastructure\Logging;

ini_set('display_errors', '1');
ini_set('display_startup_errors', '1');
error_reporting(E_ALL);

use src\ApiActionTypes\ApiActionTypes;
use src\Infrastructure\Env\Env;
use src\Infrastructure\Utils\Path;

class FileLogger
{
    const LOG_STOCK_CORRECTION_FILENAME = "logCorrectionStock";
    const LOG_STOCK_GET_FILENAME = "logGetStock";
    const MAX_SIZE_IN_BYTE = 100 * 1024;
    private string $recordableString;
    private string $apiAction;
    private bool $isScriptFinish;

    private string $errorFilePath;
    private string $apiLogFilePath;


    public function __construct(string $recordableString, Env $env, Path $path, string $apiAction = '',  bool $isScriptFinish = false)
    {
        $this->recordableString = $recordableString;
        $this->isScriptFinish = $isScriptFinish;
        $this->errorFilePath = $path->getApiLogsPath() . DIRECTORY_SEPARATOR . $env->getDefaultErrorFilename();
        $this->apiLogFilePath = $path->getApiLogsPath();
        $this->apiAction = $apiAction;
    }

    public function writeLog(): void
    {
        if ($this->apiAction === ApiActionTypes::GET_STOCKS_ACTION) {
            $this->writeGetStockLog();
        } elseif ($this->apiAction === ApiActionTypes::CORRECTION_STOCKS_ACTION) {
            $this->writeCorrectionStockLog();
        } else {
            $message = "apiAction is Empty or Invalid value" . PHP_EOL . $this->recordableString;
            $this->writeIntoDefaultErrorFile($message);
        }
    }

    private function writeGetStockLog(): void
    {
        $baseFilePath = rtrim($this->apiLogFilePath, DIRECTORY_SEPARATOR) . DIRECTORY_SEPARATOR . self::LOG_STOCK_GET_FILENAME;

        $currentFilePath = $this->getCurrentLogFilePath($baseFilePath);

        self::writeLineToFile($currentFilePath, $this->recordableString, $this->isScriptFinish);

    }

    private function writeCorrectionStockLog(): void
    {

        $baseFilePath = rtrim($this->apiLogFilePath, DIRECTORY_SEPARATOR) . DIRECTORY_SEPARATOR . self::LOG_STOCK_CORRECTION_FILENAME;

        $currentFilePath = $this->getCurrentLogFilePath($baseFilePath);

        $this->writeLineToFile($currentFilePath, $this->recordableString, $this->isScriptFinish);

    }

    private function getCurrentLogFilePath(string $baseFilePath): string
    {
        $i = 0;
        do {
            $currentFilePath = $baseFilePath . $i;
            ++$i;
        } while (file_exists($currentFilePath) && filesize($currentFilePath) >= self::MAX_SIZE_IN_BYTE);

        return $currentFilePath;
    }

    private function writeLineToFile(string $filename, string $line, bool $isScriptFinish): void
    {
        $today = date("Y-m-d H:i:s");
        if ($isScriptFinish) {
            $line .= PHP_EOL . $today . " Script is finished";
        }

        $result = true;

        if (!empty($line)) {
            $result = file_put_contents($filename, "$today $line" . PHP_EOL, FILE_APPEND | LOCK_EX);
        }

        if (!$result) {
            $message = "Failed to write to log file: $filename";
            $this->writeIntoDefaultErrorFile($message);
        }
        
    }

    private function writeIntoDefaultErrorFile(string $message)
    {
        error_log($message, 3, $this->errorFilePath);
    }
}
