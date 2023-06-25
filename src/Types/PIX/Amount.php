<?php

namespace WeDevBr\Celcoin\Types\PIX;

use WeDevBr\Celcoin\Types\Data;

class Amount extends Data
{
    public float $original;
    public int $changeType;

    public function __construct(array $data = [])
    {
        parent::__construct($data);
    }


}