<?php

namespace src\config;

use InvalidArgumentException;

class Config
{

    private CompanyConfig $companyConfig;
    private ApiConfig $apiConfig;

    public function __construct(CompanyConfig $companyConfig, ApiConfig $apiConfig)
    {
        $this->companyConfig = $companyConfig;
        $this->apiConfig = $apiConfig;
    }

    public function getCompanyConfig(): CompanyConfig
    {
        return $this->companyConfig;
    }
    public function getApiConfig(): ApiConfig
    {
        return $this->apiConfig;
    }
  
}
