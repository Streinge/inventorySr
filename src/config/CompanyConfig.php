<?php

namespace src\config;

use InvalidArgumentException;

class CompanyConfig
{
    private int $companyId;
    private string $companyToken;

    public function __construct(int $companyId, string $companyToken)
    {
        if (empty($companyId) || $companyToken) {
            throw new InvalidArgumentException('Invalid company ID or company token');
        }

        if (!is_int($companyId)) {
            throw new InvalidArgumentException('Company ID must be integer type');
        }

        if (!is_string($companyId)) {
            throw new InvalidArgumentException('Company Token must be string type');
        }
        
        $this->companyId = $companyId;
        $this->companyToken = $companyToken;
    }

    public function getCompanyId(): int
    {
        return $this->companyId;
    }

    public function getCompanyToken(): int
    {
        return $this->companyToken;
    }

}