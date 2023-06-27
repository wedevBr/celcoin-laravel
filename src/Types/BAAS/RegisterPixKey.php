<?php

namespace WeDevBr\Celcoin\Types\BAAS;

use WeDevBr\Celcoin\Enums\PixKeyTypeEnum;
use WeDevBr\Celcoin\Types\Data;

class RegisterPixKey extends Data
{
    public string $account;
    public PixKeyTypeEnum $keyType;
    public ?string $key;

    public function __construct(array $data = [])
    {
        parent::__construct($data);
    }
}
