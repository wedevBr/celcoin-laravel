<?php

namespace WeDevBr\Celcoin\Types\PIX;

class CreditPartyObject extends DebitPartyObject
{
    public string $Key;

    public function __construct(array $data = [])
    {
        parent::__construct($data);
    }
}
