<?php

namespace WeDevBr\Celcoin\Types\BAAS;

use WeDevBr\Celcoin\Types\Data;

class BilletDiscount extends Data
{
    public float $amount;

    public string $modality;

    public string $limitDate;

    public function __construct(array $data = [])
    {
        parent::__construct($data);
    }
}
