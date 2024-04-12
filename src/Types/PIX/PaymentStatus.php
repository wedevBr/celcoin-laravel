<?php

namespace WeDevBr\Celcoin\Types\PIX;

use WeDevBr\Celcoin\Types\Data;

class PaymentStatus extends Data
{
    public string $transactionId;

    public string $endtoendId;

    public string $clientCode;

    public function __construct(array $data = [])
    {
        parent::__construct($data);
    }
}
