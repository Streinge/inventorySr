<?php

declare(strict_types=1);

namespace src;

class Path
{
    const SRC_DIRECTORY = "src";
    const API_LOGS_DIRECTORY = "api" . DIRECTORY_SEPARATOR . "logs";
    const API_STOCKS_GET_DIRECTORY = "api" . DIRECTORY_SEPARATOR . "stocks" . DIRECTORY_SEPARATOR . "get";
    const API_STOCKS_CORRECTION_DIRECTORY = "api" . DIRECTORY_SEPARATOR . "stocks" . DIRECTORY_SEPARATOR . "correction";

    public function getProjectRootPath(): string
    {
        return dirname(__DIR__);
    }

    public function getSrcPath(): string
    {
        return $this->getProjectRootPath() . DIRECTORY_SEPARATOR . self::SRC_DIRECTORY;
    }

    public function getApiLogsPath(): string
    {
        return $this->getProjectRootPath() . DIRECTORY_SEPARATOR . self::API_LOGS_DIRECTORY;
    }



}
