<?php

namespace WeDevBr\Celcoin\Types\BAAS;

use WeDevBr\Celcoin\Enums\ClientFinalityEnum;
use WeDevBr\Celcoin\Types\Data;
use WeDevBr\Celcoin\Types\PIX\Debtor;

class BilletReceiver extends Data
{
    public string $document;
    public string $account;

    public function __construct(array $data = [])
    {
        parent::__construct($data);
    }
}
