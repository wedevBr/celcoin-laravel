<?php

namespace WeDevBr\Celcoin\Types\BillPayments;

use WeDevBr\Celcoin\Types\Data;

class BillData extends Data
{
    public float $value;

    public float $originalValue;

    public float $valueWithDiscount;

    public float $valueWithAdditional;

    public function __construct(array $data = [])
    {
        parent::__construct($data);
    }
}
