<?php

declare(strict_types=1);

ini_set('display_errors', '1');
ini_set('display_startup_errors', '1');
error_reporting(E_ALL);

require_once __DIR__ . '/../autoload.php';

use src\Infrastructure\Config\ConfigException;
use src\Infrastructure\Config\ConfigLoader;
use src\Infrastructure\Env\EnvException;
use src\Logging\ExceptionHandler;
use src\Infrastructure\Utils\Path;
use src\Middleware\Middleware;

try {
    $config = new ConfigLoader();
    $env = new ConfigLoader();
} catch (ConfigException|EnvException $e) {
    (new ExceptionHandler())->handleException($e, $env, new Path(), $action);
}

(new Middleware)->handle($config, $_GET);

try {
    $controller = new SwitchController()->getController($_SERVER);
} catch (ControllerException $e) {
    (new ExceptionHandler())->handleException($e, $action, $env, new Path());
}
