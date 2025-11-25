<?php

declare(strict_types=1);

namespace src\Infrastructure\Config;


class ApiConfig
{
    private string $apiPassword;

    public function __construct(string $apiPassword)
    {

        if (empty($apiPassword)) {
            throw new ConfigException('Invalid Api password');
        }

        $this->apiPassword = $apiPassword;
    }

    public function getApiPassword(): string
    {
        return $this->apiPassword;
    }

}