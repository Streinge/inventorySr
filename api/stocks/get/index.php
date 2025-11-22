<?php

declare(strict_types=1);

ini_set('display_errors', '1');
ini_set('display_startup_errors', '1');
error_reporting(E_ALL);

use src\Bootstrap;

require_once __DIR__ . '/../../../autoload.php';

$bootstrap = new Bootstrap(__DIR__);
$bootstrap->handle();
