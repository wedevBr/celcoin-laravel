<?php

namespace WeDevBr\Celcoin\Types\DDA;

use WeDevBr\Celcoin\Types\Data;

class BasicAuthentication extends Data
{
    public ?string $identification;

    public ?string $password;

    public function __construct(array $data = [])
    {
        parent::__construct($data);
    }
}
