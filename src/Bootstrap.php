<?php

declare(strict_types=1);

namespace src;

use src\config\ConfigLoader;
use src\config\ConfigException;

use src\Exceptions\HttpException;
use src\FileLogger;
use src\SrApi;

final class Bootstrap
{
    public static function handle(): void
    {
        try {
            $config = (new ConfigLoader())->loadsFromPhpFile();
        } catch (ConfigException $e) {
            FileLogger($e->getMessage(), true);
            http_response_code($e->getHttpCode());
            exit();
        }

    }
}

try {
    $config = new Config();
} catch (HttpException $e) {
    FileLogger::writeGetStockLog($e->getMessage(), true);
    http_response_code($e->getHttpCode());
    exit();
}
