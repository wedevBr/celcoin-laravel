<?php

namespace WeDevBr\Celcoin\Types\BAAS;

use WeDevBr\Celcoin\Types\Data;

class RefundPix extends Data
{
    public ?string $id;
    public ?string $endToEndId;
    public string $clientCode;
    public float $amount;
    public string $reason;
    public ?string $reversalDescription;

    public function __construct(array $data = [])
    {
        parent::__construct($data);
    }
}
