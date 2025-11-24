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

    public function handleException(Exception $e, string $action, Env $env, Path $path): void
    {
        $errorFilePath = $path->getProjectRootPath() . DIRECTORY_SEPARATOR . $env->getDefaultErrorFilename();

        if ($e instanceof ApiActionTypesException) {
            $this->handleApiActionTypesExceptions($e, $errorFilePath);
        } elseif ($e instanceof ConfigException || $e instanceof EnvException) {
            $this->handleEnvConfigWebhookExceptions($e, $env, $path, $action);
        } else {
            $this->handleUnknownExceptions($e, $errorFilePath);
        }

        exit();
    }

    private function handleApiActionTypesExceptions(Exception $e, string $errorFilePath): void
    {
        $this->handleUnknownExceptions($e, $errorFilePath);
    }

    private function handleEnvConfigWebhookExceptions(Exception $e, Env $env, Path $path, string $action): void
    {
        (new FileLogger($e->getMessage(), $env, $path, $action, true))->writeLog();
        http_response_code(500);
    }

    private function handleUnknownExceptions(Exception $e, string $errorFilePath): void
    {
        error_log($e->getMessage(), 3, $errorFilePath);
        http_response_code(500);
    }
}