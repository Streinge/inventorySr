<?php

declare(strict_types=1);

namespace src\Infrastructure\Config;

require_once __DIR__ . '/../../autoload.php';


class CompanyCredentials
{
    private int $companyId;
    private string $companyToken;

    public function __construct(int $companyId, string $companyToken)
    {
        if (empty($companyToken)) {
            throw new ConfigException('Company Token is not defined');
        }

        if (empty($companyId) || $companyId <= 0) {
            throw new ConfigException('Invalid Company ID value');
        }
        
        $this->companyId = $companyId;
        $this->companyToken = $companyToken;
    }

    public function getCompanyId(): int
    {
        return $this->companyId;
    }

    public function getCompanyToken(): string
    {
        return $this->companyToken;
    }

}
