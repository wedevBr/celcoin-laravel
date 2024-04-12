<?php

namespace WeDevBr\Celcoin\Types\Topups;

use WeDevBr\Celcoin\Types\Data;

class Phone extends Data
{
    public int $stateCode;

    public int $countryCode;

    public string $number;

    public function __construct(array $data = [])
    {
        parent::__construct($data);
    }
}
