<?php

namespace src;

use src\Exceptions\HttpException;
use src\Path;

class Config
{
    const CONFIG_FILE_NAME = "config.php";
    private ?string $configFilePath;
    private string $companyId;
    private string $companyToken;


    public function __construct(?string $configFilePath = null)
    {
        $this->configFilePath = $configFilePath;

        if (!$configFilePath) {
            $basePath = Path::getProjectRootPath();
            $this->configFilePath = rtrim($basePath, DIRECTORY_SEPARATOR) . DIRECTORY_SEPARATOR . self::CONFIG_FILE_NAME;
        }

        $data = $this->getConfigData();

        foreach ($data as $key => $value) {
            if (!property_exists($this, $key)) {
                throw new HttpException("Array key {$key} from config file don't exists in properties class Config.php", 500);
            }
            $this->{$key} = $value;
        }
    }

    /**
     * Загружает и возвращает данные конфигурации из файла
     *
     * @return array
     * @throws HttpException
     */

    public function getConfigData(): array
    {

        if (!file_exists($this->configFilePath)) {
            throw new HttpException("Config file don't exists for path: " . $this->configFilePath, 500);
        }

        $configData = include $this->configFilePath;

        if (!is_array($configData)) {
            throw new HttpException("Config data must be array", 500);
        }

        if (empty($configData)) {
            throw new HttpException("Config data don't defined", 500);
        }

        return $configData;
    }

    public function getConfigFilePath(): string
    {
        return $this->configFilePath;
    }

    public function getCallCenterCompanyId(): string
    {
        return $this->companyId;
    }
    public function getCallCenterCompanyToken(): string
    {
        return $this->companyToken;
    }


    
}
