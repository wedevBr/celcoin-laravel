<?php

namespace WeDevBr\Celcoin\Types\BillPayments;

use WeDevBr\Celcoin\Types\Data;

class BillData extends Data
{
    public int $value;
    public int $originalValue;
    public int $valueWithDiscount;
    public int $valueWithAdditional;

    public function __construct(array $data = [])
    {
        parent::__construct($data);
    }
}
