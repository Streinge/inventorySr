<?php

namespace src\config;

use InvalidArgumentException;

class ApiConfig
{
    private string $apiPassword;

    public function __construct(string $apiPassword)
    {

        if (empty($apiPassword)) {
            throw new InvalidArgumentException('Invalid Api password');
        }

        $this->apiPassword = $apiPassword;
    }

    public function getApiPassword(): int
    {
        return $this->apiPassword;
    }

}