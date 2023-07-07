<?php

namespace WeDevBr\Celcoin\Types\PIX;

use WeDevBr\Celcoin\Types\Data;

class AmountFine extends Data
{
    public bool $hasAbatement;
    public string $amountPerc;
    public string $modality;
}
