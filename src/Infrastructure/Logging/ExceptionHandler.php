<?php

declare(strict_types=1);

namespace src\Logging;

use Exception;
use src\apiActionTypes\ApiActionTypesException;
use src\Infrastructure\Config\ConfigException;
use src\Infrastructure\Env\Env;
use src\Infrastructure\Env\EnvException;
use src\Infrastructure\Logging\FileLogger;
use src\Infrastructure\Utils\Path;
use src\webhook\WebhookException;


class ExceptionHandler
{

    public function handleException(Exception $e, Env $env, Path $path, string $action = ''): void
    {
        $errorFilePath = $path->getProjectRootPath() . DIRECTORY_SEPARATOR . $env->getDefaultErrorFilename();

        

        if ($e instanceof ConfigException || $e instanceof EnvException || $e instanceof WebhookException) {
            $this->handleEnvConfigWebhookExceptions($e, $env, $path, $action);
        } else {
            $this->handleUnknownExceptions($e, $errorFilePath);
        }

        exit();
    }


    private function handleEnvConfigWebhookExceptions(Exception $e, Env $env, Path $path, string $action): void
    {
        $this->outputJsonError($e, 500);
        (new FileLogger($e->getMessage(), $env, $path, $action, true))->writeLog();
    }

    private function handleUnknownExceptions(Exception $e, string $errorFilePath): void
    {
        $this->outputJsonError($e, 500);
        error_log($e->getMessage(), 3, $errorFilePath);
    }

    private function outputJsonError(Exception $e, int $httpCode): void
    {
        http_response_code($httpCode);
        header('Content-Type: application/json');
        echo json_encode([
            'error' => $e->getMessage(),
            'type'  => get_class($e),
            'code'  => $httpCode
        ]);
    }
}