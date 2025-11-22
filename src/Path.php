<?php

namespace src;

class Path
{
    const SRC_DIRECTORY = "src";
    const API_LOGS_DIRECTORY = "api" . DIRECTORY_SEPARATOR . "logs";
    const API_STOCKS_GET_DIRECTORY = "api" . DIRECTORY_SEPARATOR . "stocks" . DIRECTORY_SEPARATOR . "get";
    const API_STOCKS_CORRECTION_DIRECTORY = "api" . DIRECTORY_SEPARATOR . "stocks" . DIRECTORY_SEPARATOR . "CORRECTION";

    public static function getProjectRootPath(): string
    {
        return dirname(__DIR__);
    }

    public static function getSrcPath(): string
    {
        return self::getProjectRootPath() . DIRECTORY_SEPARATOR . self::SRC_DIRECTORY;
    }

    public static function getApiLogsPath(): string
    {
        return self::getProjectRootPath() . DIRECTORY_SEPARATOR . self::API_LOGS_DIRECTORY;
    }



}
