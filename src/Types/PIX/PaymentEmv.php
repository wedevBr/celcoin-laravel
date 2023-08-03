<?php

namespace WeDevBr\Celcoin\Types\PIX;

use WeDevBr\Celcoin\Types\Data;

class PaymentEmv extends Data
{
    public string $emv;

    /**
     * @param array $data
     */
    public function __construct(array $data = [])
    {
        parent::__construct($data);
    }
}
