<?php

namespace WeDevBr\Celcoin\Types\PIX;

use WeDevBr\Celcoin\Types\Data;

class PaymentEndToEnd extends Data
{
    public string $dpp;

    public function __construct(array $data = [])
    {
        parent::__construct($data);
    }
}
