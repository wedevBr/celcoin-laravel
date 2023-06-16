<?php

namespace WeDevBr\Celcoin\Types\InternationalTopups;

use WeDevBr\Celcoin\Types\Data;

class Confirm extends Data
{
    public ?int $externalNsu;
    public ?string $externalTerminal;

    public function __construct(array $data = [])
    {
        parent::__construct($data);
    }
}
