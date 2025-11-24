<?php

declare(strict_types=1);

namespace src;

require_once __DIR__ . '/../autoload.php';

use InvalidArgumentException;
use JsonException;

class WebhookParser
{
    public array $data = [];
    private string $orderId;
    private string $orderStatusId;
    private array $stringFields;

    public function __construct(?string $json)
    {
        
        if (empty($json)) {
            throw new Webhook("Empty incoming JSON");
        }
        
        if (!$json || empty($json)) {
            throw new InvalidArgumentException("Webhook is NULL or empty");
        }

        try {
            $this->data = json_decode($json, true, 512, JSON_THROW_ON_ERROR);
        } catch (JsonException $e) {
            throw new InvalidArgumentException('Invalid JSON: ' . $e->getMessage());
        }

        $this->orderId = $this->data['id'] ?? '';
        $this->orderStatusId = $this->data['status']['id'] ?? '';
        $this->stringFields = $this->data['data']['stringFields'] ?? [];
    }

    public function getOrderId()
    {
        if (empty($this->orderId)) {
            throw new InvalidArgumentException("OrderID is NULL or empty");
        }

        return $this->orderId;
    }

    public function getOrderStatusId()
    {
        if (empty($this->orderStatusId)) {
            throw new InvalidArgumentException("OrderStatusID is NULL or empty");
        }

        return $this->orderStatusId;
    }

    public function getNormalizedJson()
    {
        return json_encode($this->data, JSON_UNESCAPED_UNICODE|JSON_UNESCAPED_SLASHES);
    }

    public function getStringFields()
    {
        return $this->stringFields;
    }
}