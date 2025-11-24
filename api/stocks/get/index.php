<?php

declare(strict_types=1);

ini_set('display_errors', '1');
ini_set('display_startup_errors', '1');
error_reporting(E_ALL);

use src\apiActionTypes\ApiActionTypes;
use src\Bootstrap;
use src\config\ConfigLoader;
use src\env\EnvLoader;
use src\webhook\Webhook;

require_once __DIR__ . '/../../../autoload.php';

$apiActionTypes = new ApiActionTypes(__DIR__);
$envLoader = new EnvLoader();
$configLoader = new ConfigLoader();
$webHook = new Webhook(file_get_contents('php://input'));

$bootstrap = new Bootstrap($apiActionTypes, $envLoader, $configLoader, $webHook);
$bootstrap->handle();
