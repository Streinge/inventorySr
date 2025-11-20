<?php

namespace src\config;

use src\Path;
use src\config\ConfigException;
use src\config\Config;

class ConfigLoader
{
    const CONFIG_FILE_NAME = "config.php";
  
    /**
     * Загружает и возвращает данные конфигурации из файла
     *
     * @return array
     * @throws ConfigException
     */

    public function loadsFromPhpFile(?string $configFilePath = null): Config
    {

        if (!$configFilePath) {
            $basePath = Path::getProjectRootPath();
            $configFilePath = rtrim($basePath, DIRECTORY_SEPARATOR) . DIRECTORY_SEPARATOR . self::CONFIG_FILE_NAME;
        }

        if (!file_exists($configFilePath)) {
            throw new ConfigException("Config file don't exists for path: " . $configFilePath, 500);
        }

        $configData = include $configFilePath;

        if (!is_array($configData)) {
            throw new ConfigException("Config data must be array", 500);
        }

        if (empty($configData)) {
            throw new ConfigException("Config data don't defined", 500);
        }

        return new Config($configData);
    }
  
}
