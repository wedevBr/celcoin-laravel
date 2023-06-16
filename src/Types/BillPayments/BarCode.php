<?php

namespace WeDevBr\Celcoin\Types\BillPayments;

use WeDevBr\Celcoin\Types\Data;

class BarCode extends Data
{
    public string $type;
    public ?string $digitable;
    public ?string $barCode;

    public function __construct(array $data = [])
    {
        parent::__construct($data);
    }
}
