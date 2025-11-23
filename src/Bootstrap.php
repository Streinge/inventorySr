<?php

declare(strict_types=1);

namespace src;

use src\apiActionTypes\ApiActionTypes;
use src\apiActionTypes\ApiActionTypesException;
use src\config\ConfigLoader;
use src\config\ConfigException;

use src\env\EnvException;
use src\env\EnvLoader;


final class Bootstrap

{
    private ApiActionTypes $apiActionTypes;
    private EnvLoader $envLoader;
    private ConfigLoader $configLoader;
    public function __construct(
        ApiActionTypes $apiActionTypes,
        EnvLoader $envLoader,
        ConfigLoader $configLoader
    )
    {
        $this->apiActionTypes = $apiActionTypes;
        $this->envLoader = $envLoader;
        $this->configLoader = $configLoader;
    }
    public function handle(): void
    {
        $action = '';
        $env = null;
        try {
            $action = $this->apiActionTypes->getApiAction();

            $env = $this->envLoader->loadFromPhpFile();

            $config = $this->configLoader->loadFromPhpFile();


        } catch (ConfigException|EnvException|ApiActionTypesException $e) {
            (new ExceptionHandler($e))->handleException($action, $env);
        }

    }

}
