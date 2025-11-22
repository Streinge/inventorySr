<?php

namespace src;

use Exception;
use src\ApiActionTypes\ApiActionTypes;
use src\config\ConfigException;
use src\env\Env;
use src\env\EnvException;

class ExceptionHandler
{
    public Exception $e;
    public function __construct(Exception $e)
    {
        $this->e = $e;
    }

    public function handleException(string $action, Env $env)
    {

        if ($this->e instanceof ApiActionTypes) {
            error_log($this->e->getMessage(), Path::getProjectRootPath() . "error.txt");
            http_response_code(500);
            exit();
        }

        if ($this->e instanceof ConfigException || $this->e instanceof EnvException) {
            FileLogger::writeGetStockLog($this->e->getMessage());
            http_response_code(500);
            exit();
        }
    }
}