<?php

namespace WeDevBr\Celcoin\Types\PIX;

use WeDevBr\Celcoin\Types\Data;

class DICT extends Data
{
    public string $payerId;

    public string $key;

    public array $keys;

    public function __construct(array $data = [])
    {
        parent::__construct($data);
    }
}
