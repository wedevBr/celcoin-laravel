<?php

namespace WeDevBr\Celcoin\Types\PIX;

use WeDevBr\Celcoin\Types\Data;

class AmountInterest extends Data
{
    public bool $hasInterest;
    public string $amountPerc;
    public string $modality;
}
