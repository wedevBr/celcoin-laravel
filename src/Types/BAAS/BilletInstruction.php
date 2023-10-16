<?php

namespace WeDevBr\Celcoin\Types\BAAS;

use WeDevBr\Celcoin\Types\Data;

class BilletInstruction extends Data
{

    public ?float $fine;
    public ?float $interest;
    public ?BilletDiscount $discount;

    public function __construct(array $data = [])
    {
        parent::__construct($data);
    }
}
