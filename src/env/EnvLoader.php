<?php

namespace src\env;

use src\config\ApiConfig;
use src\config\CompanyCredentials;
use src\Path;
use src\config\ConfigException;
use src\config\Config;

class EnvLoader
{
    const ENV_FILE_NAME = ".env.php";
  
    /**
     * Загружает и возвращает данные окружения из файла
     *
     * @return array
     * @throws EnvException
     */

    public function loadsFromPhpFile(?string $envFilePath = null): Env
    {

        if (!$envFilePath) {
            $basePath = Path::getProjectRootPath();
            $envFilePath = rtrim($basePath, DIRECTORY_SEPARATOR) . DIRECTORY_SEPARATOR . self::ENV_FILE_NAME;
        }

        if (!file_exists($envFilePath)) {
            throw new EnvException("Environment file don't exists for path: " . $envFilePath);
        }

        $envData = include $envFilePath;

        if (!is_array($envData)) {
            throw new EnvException("Environment data must be array");
        }

        if (empty($envData)) {
            throw new EnvException("Environment data don't defined");
        }

        $appEnvType = (string) $envData['appEnv'] ?? '';
        $defaultErrorFilename = (string) $envData['errorFilename'] ?? '';

        return new Env($appEnvType, );
    }
  
}
