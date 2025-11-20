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
        $this->companyToken = $configData['companyToken'] ?? '';
        $this->generalPassword = $configData['generalPassword'] ?? '';

        if (empty($this->companyId) || empty($this->companyToken) || empty($this->generalPassword)) {
            throw new ConfigException("Invalid config data", 500);
        }
        
    }

    public function getCompanyId(): string
    {
        return $this->companyId;
    }
    public function getCompanyToken(): string
    {
        return $this->companyToken;
    }
  
}
