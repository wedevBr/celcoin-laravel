<?php

namespace WeDevBr\Celcoin\Types\BAAS;

use WeDevBr\Celcoin\Types\Data;

class Account extends Data
{
    public string $account;

    public function __construct(array $data = [])
    {
        parent::__construct($data);
    }
}
