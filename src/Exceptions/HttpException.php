<?php 

namespace src\Exceptions;

require_once __DIR__ . '/../autoload.php';

use Exception;
use Throwable;

class HttpException extends Exception
{
    protected int $httpCode;
    
    public function __construct(string $message = "", int $code = 0, ?Throwable $previous = null)
    {
        parent::__construct($message, $code, $previous);
        $this->httpCode = $code;
    }

    public function getHttpCode()
    {
        return $this->httpCode;
    }


}