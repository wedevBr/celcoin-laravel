<?php

namespace WeDevBr\Celcoin\Types\PIX;

use WeDevBr\Celcoin\Types\Data;

class COBGet extends Data
{
    public string $transactionId;
    public string $transactionIdentification;
    public string $clientRequestId;

    public function __construct(array $data = [])
    {
        parent::__construct($data);
    }
}
