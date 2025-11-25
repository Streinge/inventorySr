<?php

declare(strict_types=1);

namespace src\Infrastructure\Config;

use InvalidArgumentException;

class Config
{

    private CompanyCredentials $companyConfig;
    private ApiConfig $apiConfig;

    public function __construct(CompanyCredentials $companyConfig, ApiConfig $apiConfig)
    {
        $this->companyConfig = $companyConfig;
        $this->apiConfig = $apiConfig;
    }

    public function getCompanyConfig(): CompanyCredentials
    {
        return $this->companyConfig;
    }
    public function getApiConfig(): ApiConfig
    {
        return $this->apiConfig;
    }
  
}
