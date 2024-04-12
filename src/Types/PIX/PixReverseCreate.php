<?php

namespace WeDevBr\Celcoin\Types\PIX;

use WeDevBr\Celcoin\Types\Data;

class PixReverseCreate extends Data
{
    public string $clientCode;

    public float $amount;

    public string $reason;

    public string $additionalInformation;

    public string $reversalDescription;

    public function __construct(array $data = [])
    {
        parent::__construct($data);
    }
}
