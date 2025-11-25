<?php 

declare(strict_types=1);

namespace src\Http\Middleware;

use RuntimeException;

class MiddlewareException extends RuntimeException
{
    public function __construct(string $message, int $httpCode)
    {
        parent::__construct($message, $httpCode);

    }
}