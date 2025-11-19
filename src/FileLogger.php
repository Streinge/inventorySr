<?php

namespace src;

ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

use src\Path;

class FileLogger
{
    const LOG_STOCK_CORRECTION_FILENAME = "logCorrection";
    const LOG_STOCK_GET_FILENAME = "logGetStock";
    const MAX_SIZE_IN_BYTE = 100 * 1024;

    public static function writeGetStockLog(string $recordableString, bool $isScriptFinish = false): void
    {

        $baseFilePath = rtrim(Path::getApiLogsPath(), DIRECTORY_SEPARATOR) . DIRECTORY_SEPARATOR . self::LOG_STOCK_GET_FILENAME;

        var_dump($baseFilePath);

        $i = 0;
        do {
            $currentFilePath = $baseFilePath . $i;
            ++$i;
        } while (file_exists($currentFilePath) && filesize($currentFilePath) >= self::MAX_SIZE_IN_BYTE);

        self::writeLineToFile($currentFilePath, $recordableString, $isScriptFinish);

    }

    public static function writeCorrectionStockLog(string $recordableString, bool $isScriptFinish = false): void
    {

        $baseFilePath = rtrim(Path::getApiLogsPath(), DIRECTORY_SEPARATOR) . DIRECTORY_SEPARATOR . self::LOG_STOCK_CORRECTION_FILENAME;

        $i = 0;
        do {
            $currentFilePath = $baseFilePath . $i;
            ++$i;
        } while (file_exists($currentFilePath) && filesize($currentFilePath) >= self::MAX_SIZE_IN_BYTE);

        self::writeLineToFile($currentFilePath, $recordableString, $isScriptFinish);

    }

    private static function writeLineToFile(string $filename, string $line, bool $isScriptFinish): void
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
            error_log("Failed to write to log file: $filename");
        }
        
    }
}
