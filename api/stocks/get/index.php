<?php

ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

require_once __DIR__ . '/../../../autoload.php';

use src\Config;
use src\Exceptions\HttpException;
use src\FileLogger;

try {
    $config = new Config();
} catch (HttpException $e) {
    FileLogger::writeGetStockLog($e->getMessage(), true);
    http_response_code($e->getHttpCode());
}

FileLogger::writeGetStockLog("Test");
