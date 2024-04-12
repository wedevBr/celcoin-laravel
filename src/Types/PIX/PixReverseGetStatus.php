<?php

namespace WeDevBr\Celcoin\Types\PIX;

use WeDevBr\Celcoin\Types\Data;

class PixReverseGetStatus extends Data
{
    public string $returnIdentification;

    public int $transactionId;

    public string $clientCode;

    public function __construct(array $data = [])
    {
        parent::__construct($data);
    }
}
