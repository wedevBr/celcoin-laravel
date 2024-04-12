<?php

namespace WeDevBr\Celcoin\Types\BAAS;

use WeDevBr\Celcoin\Types\Data;

class BilletReceiver extends Data
{
    public string $document;

    public string $account;

    public function __construct(array $data = [])
    {
        parent::__construct($data);
    }
}
