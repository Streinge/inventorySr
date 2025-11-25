<?php

declare(strict_types=1);

namespace src\Infrastructure\Config;

use src\Infrastructure\Utils\Path;

class ConfigLoader
{
    const CONFIG_FILE_NAME = "config.php";

    /**
     * Загружает и возвращает данные конфигурации из файла
     *
     * @param string|null $configFilePath
     * @return Config
     */

    public function loadFromPhpFile(?string $configFilePath = null): Config
    {

        if (!$configFilePath) {
            $basePath = (new Path())->getProjectRootPath();
            $configFilePath = rtrim($basePath, DIRECTORY_SEPARATOR) . DIRECTORY_SEPARATOR . self::CONFIG_FILE_NAME;
        }

        if (!file_exists($configFilePath)) {
            throw new ConfigException("Config file don't exists for path: " . $configFilePath);
        }

        $configData = include $configFilePath;

        if (!is_array($configData)) {
            throw new ConfigException("Config data must be array");
        }

        if (empty($configData)) {
            throw new ConfigException("Config data don't defined");
        }

        $companyId = (int) $configData['wareHouseCompany']['SrCredentials']['companyId'] ?? 0;
        $companyToken = (string) $configData['wareHouseCompany']['SrCredentials']['companyToken'] ?? '';

        $sRConfigCredentials = new CompanyCredentials($companyId, $companyToken);

        $scriptPassword = (string) $configData['apiScriptData']['scriptPassword'] ?? '';

        $apiScriptConfig = new ApiConfig($scriptPassword);


        return new Config($sRConfigCredentials, $apiScriptConfig);
    }
  
}
