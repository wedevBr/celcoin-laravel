<?php

namespace WeDevBr\Celcoin\Types\BAAS;

use WeDevBr\Celcoin\Enums\BAASWebhookEnum;
use WeDevBr\Celcoin\Types\Data;

class RegisterWebhooks extends Data
{
    public BAASWebhookEnum $entity;
    public string $webhookUrl;
    public ?Auth $auth;

    public function __construct(array $data = [])
    {
        $data['auth'] = new Auth($data['auth'] ?? []);
        parent::__construct($data);
    }
}
