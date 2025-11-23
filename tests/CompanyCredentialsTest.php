<?php

declare(strict_types=1);

namespace tests;

use PHPUnit\Framework\TestCase;
use src\config\CompanyCredentials;
use src\config\ConfigException;

require_once __DIR__ . '/../autoload.php';

class CompanyCredentialsTest extends TestCase
{

    public function testNegativeCompanyIdException()
    {
        $this->expectException(ConfigException::class);
        new CompanyCredentials(-123, 'token123');

    }

    public function testZeroCompanyIdException()
    {
        $this->expectException(ConfigException::class);
        new CompanyCredentials(0, 'token123');
    }

    public function testEmptyCompanyTokenException()
    {
        $this->expectException(ConfigException::class);
        new CompanyCredentials(123, '');
    }

    public function testGetters()
    {
        $companyId = 123;
        $companyToken = 'token123';

        $companyCredentials = new CompanyCredentials($companyId, $companyToken);

        $this->assertSame($companyId, $companyCredentials->getCompanyId());
        $this->assertSame($companyToken, $companyCredentials->getCompanyToken());
    }



}

