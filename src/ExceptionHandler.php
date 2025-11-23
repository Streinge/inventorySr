<?php

declare(strict_types=1);

namespace src;

use Exception;
use src\apiActionTypes\ApiActionTypesException;
use src\config\ConfigException;
use src\env\Env;
use src\env\EnvException;

class ExceptionHandler
{
    public Exception $e;
    private string $errorFilePath;
    public function __construct(Exception $e)
    {
        $this->e = $e;
    }

    public function handleException(string $action, Env $env)
    {
        $this->errorFilePath = (new Path())->getProjectRootPath() . DIRECTORY_SEPARATOR . $env->getDefaultErrorFilename();
        if ($this->e instanceof ApiActionTypesException) {
            $this->handleApiActionTypesExceptions();
        } elseif ($this->e instanceof ConfigException || $this->e instanceof EnvException) {
            $this->handleEnvOrConfigExceptions($env, $action);
        } else {
            $this->handleUnknownExceptions();
        }

        exit();
    }

    private function handleApiActionTypesExceptions()
    {
        error_log($this->e->getMessage(), $this->errorFilePath);
        http_response_code(500);
    }

    private function handleEnvOrConfigExceptions(Env $env, string $action)
    {
        (new FileLogger($this->e->getMessage(), $env, $action,true))->writeLog();
        http_response_code(500);
    }

    private function handleUnknownExceptions()
    {
        error_log($this->e->getMessage(), $this->errorFilePath);
        http_response_code(500);
    }
}