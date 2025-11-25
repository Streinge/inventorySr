<?php

declare(strict_types=1);

namespace src\Infrastructure\Env;

use src\Path;

class EnvLoader
{
    const ENV_FILE_NAME = ".env.php";

    /**
     * Загружает и возвращает данные окружения из файла
     *
     * @param string|null $envFilePath
     * @return Env
     */

    public function loadFromPhpFile(?string $envFilePath = null): Env
    {

        if (!$envFilePath) {
            $basePath = (new Path())->getProjectRootPath();
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
        $sRUrlServer = (string) $envData['apiSrServer'][$appEnvType] ?? '';

        return new Env($appEnvType, $defaultErrorFilename, $sRUrlServer);
    }
  
}
