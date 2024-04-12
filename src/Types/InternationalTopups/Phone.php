<?php

namespace WeDevBr\Celcoin\Types\InternationalTopups;

use WeDevBr\Celcoin\Types\Data;

class Phone extends Data
{
    public string $number;

    public ?int $countryCode;

    public ?int $stateCode;

    public function __construct(array $data = [])
    {
        parent::__construct($data);
    }
}
