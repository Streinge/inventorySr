<?php

declare(strict_types=1);

namespace src\Infrastructure\Env;


class Env
{

    const APP_ENV_TYPES = ['production', 'development'];
    private string $appEnvType;
    private string $defaultErrorFilename;
    private string $sRApiUrl;

    public function __construct(string $appEnvType, string $defaultErrorFilename, string $sRApiUrl)
    {
        if (!in_array($appEnvType, self::APP_ENV_TYPES)) {
            throw new EnvException("Invalid value type application environment");
        }

        if (empty($sRApiUrl)) {
            throw new EnvException("Invalid URL SalesRender server");
        }

        $this->appEnvType = $appEnvType;
        $this->defaultErrorFilename = (!empty($defaultErrorFilename)) ? $defaultErrorFilename : "error.txt";
        $this->sRApiUrl = $sRApiUrl;
    }

    public function getAppEnvType(): string
    {
        return $this->appEnvType;
    }

    public function getDefaultErrorFilename(): string
    {
        return $this->defaultErrorFilename;
    }

    public function getSrApiUrl(): string
    {
        return $this->sRApiUrl;
    }
  
}
