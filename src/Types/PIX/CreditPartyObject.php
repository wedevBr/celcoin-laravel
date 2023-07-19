<?php

namespace WeDevBr\Celcoin\Types\PIX;

class CreditPartyObject extends DebitPartyObject
{
    public string $Key;

    /**
     * @param array $data
     */
    public function __construct(array $data = [])
    {
        parent::__construct($data);
    }
}
