<?php

declare(strict_types=1);

namespace src\webhook;

ini_set('display_errors', '1');
ini_set('display_startup_errors', '1');
error_reporting(E_ALL);

class Webhook

{
    private string $incomingJson;

    public function __construct(string $json)
    {
        $this->incomingJson = $json;
    }

    public function loadData()
    {
        if ($this->incomingJson === false) {
            throw new WebhookException("Error reading the stream php://input");
        }

        if (empty($this->incomingJson)) {
            throw new WebhookException("Error reading the stream php://input");
        }

    }

    public function getIncominJson()
    {
        return $this->incomingJson;
    }

}
