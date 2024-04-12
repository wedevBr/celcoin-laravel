<?php

namespace WeDevBr\Celcoin\Types\BAAS;

use WeDevBr\Celcoin\Types\Data;

class Tag extends Data
{
    public ?string $key;

    public ?string $data;

    public function __construct(array $data = [])
    {
        parent::__construct($data);
    }
}
