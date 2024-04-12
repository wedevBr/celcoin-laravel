<?php

namespace WeDevBr\Celcoin\Types\BAAS;

use WeDevBr\Celcoin\Types\Data;

class Auth extends Data
{
    public ?string $login;

    public ?string $pwd;

    public ?string $type;

    public function __construct(array $data = [])
    {
        parent::__construct($data);
    }
}
