<?php

namespace WeDevBr\Celcoin\Types\PIX;

use WeDevBr\Celcoin\Types\Data;

class AmountDicount extends Data
{
    public array $discountDateFixed;

    public bool $hasDicount;

    public string $modality;

    public string $amountPerc;

    public function __construct(array $data = [])
    {
        parent::__construct($data);
    }
}
