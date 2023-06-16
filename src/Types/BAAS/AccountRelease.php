<?php

namespace WeDevBr\Celcoin\Types\BAAS;

use WeDevBr\Celcoin\Types\Data;

class AccountRelease extends Data
{
    public ?string $clientCode;
    public ?float $amount;
    public ?string $type;
    public ?string $description;

    public function __construct(array $data = [])
    {
        parent::__construct($data);
    }
}
