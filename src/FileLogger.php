<?php

declare(strict_types=1);

namespace src;

ini_set('display_errors', '1');
ini_set('display_startup_errors', '1');
error_reporting(E_ALL);

use src\ApiActionTypes\ApiActionTypes;
use src\env\Env;

class FileLogger
{
    const LOG_STOCK_CORRECTION_FILENAME = "logCorrection";
    const LOG_STOCK_GET_FILENAME = "logGetStock";
    const MAX_SIZE_IN_BYTE = 100 * 1024;
    private string $recordableString;
    private string $apiAction;
    private bool $isScriptFinish;

    private string $errorFilePath;


    public function __construct(string $recordableString, Env $env, Path $path, string $apiAction,  bool $isScriptFinish = false)
    {
        $this->recordableString = $recordableString;
        $this->isScriptFinish = $isScriptFinish;
        $this->errorFilePath = (new Path())->getProjectRootPath() . DIRECTORY_SEPARATOR . $env->getDefaultErrorFilename();
        $this->apiAction = $apiAction;
    }

    public function writeLog(): void
    {
        if ($this->apiAction === ApiActionTypes::GET_STOCKS_ACTION) {
            $this->writeGetStockLog();
        } elseif ($this->apiAction === ApiActionTypes::CORRECTION_STOCKS_ACTION) {
            $this->writeCorrectionStockLog();
        } else {
            error_log("Logs do not write because api action has invalid value", 3, $this->errorFilePath);
        }
    }

    private function writeGetStockLog(): void
    {
        $baseFilePath = rtrim((new Path())->getApiLogsPath(), DIRECTORY_SEPARATOR) . DIRECTORY_SEPARATOR . self::LOG_STOCK_GET_FILENAME;

        $currentFilePath = $this->getCurrentLogFilePath($baseFilePath);

        self::writeLineToFile($currentFilePath, $this->recordableString, $this->isScriptFinish);

    }

    private function writeCorrectionStockLog(): void
    {

        $baseFilePath = rtrim((new Path())->getApiLogsPath(), DIRECTORY_SEPARATOR) . DIRECTORY_SEPARATOR . self::LOG_STOCK_CORRECTION_FILENAME;

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
            error_log("Failed to write to log file: $filename", 3, $this->errorFilePath);
        }
        
    }
}
