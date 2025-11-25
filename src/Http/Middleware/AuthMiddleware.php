<?php

declare(strict_types=1);

ini_set('display_errors', '1');
ini_set('display_startup_errors', '1');
error_reporting(E_ALL);

namespace src\Middleware;

use src\Infrastructure\Config\Config;
use src\Http\Middleware\MiddlewareException;

class AuthMiddleware
{
    public function handle(Config $config, array $passwordData)
    {
        $configPassword = $config->getApiConfig()->getApiPassword();
        $requestPassword = $passwordData['pass'] ?? '';

        if (!hash_equals($configPassword, $requestPassword)) {
           throw new MiddlewareException("Unautorized", 401);
        }
        
        return true;
    }
}