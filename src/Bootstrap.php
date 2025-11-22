<?php

declare(strict_types=1);

namespace src;

use src\ApiActionTypes\ApiActionTypes;
use src\apiActionTypes\ApiActionTypesException;
use src\config\ConfigLoader;
use src\config\ConfigException;

use src\env\EnvException;
use src\env\EnvLoader;


final class Bootstrap

{

    public string $indexPath;
    public function __construct(string $indexPath)
    {
        $this->indexPath = $indexPath;
    }
    public function handle(): void
    {
        $action = '';
        try {
            $env = (new EnvLoader())->loadsFromPhpFile();
            $action = (new ApiActionTypes($this->indexPath))->getApiAction();
            $config = (new ConfigLoader())->loadsFromPhpFile();


        } catch (ConfigException|EnvException|ApiActionTypesException $e) {
            (new ExceptionHandler($e))->handleException($action, $env);
        }

    }


}
