<?php

declare(strict_types=1);

ini_set('display_errors', '1');
ini_set('display_startup_errors', '1');
error_reporting(E_ALL);

namespace src\Middleware;

use src\Http\Middleware\MiddlewareException;
use src\Infrastructure\Config\Config;
use src\Logging\ExceptionHandler;

class Middleware
{
    public function handle(Config $config, array $data): void
    {
        $middlewareStack = [
            new AuthMiddleware()
        ];

        foreach ($middlewareStack as $middleware) {
            try {
                $middleware->handle($config, $data);
            } catch (MiddlewareException $e) {
                (new ExceptionHandler())->handleException($e, $action, $env, $path);
            }
        }
    }
}