<?php

namespace WeDevBr\Celcoin\Types\Topups;

use WeDevBr\Celcoin\Types\Data;

class TopupData extends Data
{
    public ?float $value;

    public function __construct(array $data = [])
    {
        parent::__construct($data);
    }
}
