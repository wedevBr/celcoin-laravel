<?php

namespace WeDevBr\Celcoin\Types\PIX;

use WeDevBr\Celcoin\Types\Data;

class DiscountDateFixed extends Data
{
    public string $date;

    public string $amountPerc;

    public function __construct(array $data = [])
    {
        parent::__construct($data);
    }
}
