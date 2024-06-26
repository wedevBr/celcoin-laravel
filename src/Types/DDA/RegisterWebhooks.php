<?php

namespace WeDevBr\Celcoin\Types\DDA;

use WeDevBr\Celcoin\Enums\DDAWebhooksTypeEventEnum;
use WeDevBr\Celcoin\Types\Data;

class RegisterWebhooks extends Data
{
    public DDAWebhooksTypeEventEnum $typeEventWebhook;

    public string $url;

    public ?BasicAuthentication $basicAuthentication;

    public ?OAuthTwo $oAuthTwo;

    public function __construct(array $data = [])
    {
        $data['basicAuthentication'] = new BasicAuthentication($data['basicAuthentication'] ?? []);
        $data['oAuthTwo'] = new OAuthTwo($data['oAuthTwo'] ?? []);
        parent::__construct($data);
    }
}
