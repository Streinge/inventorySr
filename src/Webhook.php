<?php

namespace src;

ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);



require_once __DIR__ . '/../autoload.php';

use Exception;

class Webhook

{
    private string $incomingPassword;
    private Config $config;
    private ?Webhook $webhook = null;
    private string $incomingJson;

    public function __construct(string $json)
    {
        $this->incomingJson = $json;

    }

    
        if (empty($json)) {
            throw new Exception("Empty incoming JSON");
        }

        if (!isset($_GET['pass']) || empty($_GET['pass'])) {
            throw new Exception("Wrong http request: param password is not exists");
        }
        
        $this->incomingPassword = $_GET['pass'];
        $this->config = new Config();

        return self::$webhook;
        
    }

    public static function isValid():bool
    {
        
        $generalPassword = self::$webhook->config->getGeneralPass();

        return $generalPassword === (string) self::$webhook->incomingPassword;

    }

    public function getIncomingPassword():string
    {
        return $this->incomingPassword;
    }

}
