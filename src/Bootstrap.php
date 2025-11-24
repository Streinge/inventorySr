<?php

declare(strict_types=1);

namespace src;

use src\apiActionTypes\ApiActionTypes;
use src\apiActionTypes\ApiActionTypesException;
use src\config\ConfigLoader;
use src\config\ConfigException;
use src\webhook\WebhookException;
use src\webhook\Webhook;
use src\env\EnvException;
use src\env\EnvLoader;


final class Bootstrap

{
    private ApiActionTypes $apiActionTypes;
    private EnvLoader $envLoader;
    private ConfigLoader $configLoader;
    private Webhook $webhook;

    public function __construct(
        ApiActionTypes $apiActionTypes,
        EnvLoader $envLoader,
        ConfigLoader $configLoader,
        Webhook $webhook
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

            $webhookData = $this->webhook->loadData();


        } catch (ConfigException|EnvException|ApiActionTypesException|WebhookException $e) {
            (new ExceptionHandler())->handleException($e, $action, $env, (new Path()));
        }

    }

}
