<?php

namespace WeDevBr\Celcoin\Types\PIX;

use WeDevBr\Celcoin\Types\Data;

class AmountAbatement extends Data
{
    public bool $hasAbatement;
    public string $amountPerc;
    public string $modality;

    public function __construct(array $data = [])
    {
        parent::__construct($data);
    }

}