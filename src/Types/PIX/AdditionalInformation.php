<?php

namespace WeDevBr\Celcoin\Types\PIX;

use WeDevBr\Celcoin\Types\Data;

class AdditionalInformation extends Data
{
    public string $key;

    public string $value;

    public function __construct(array $data = [])
    {
        parent::__construct($data);
    }
}
