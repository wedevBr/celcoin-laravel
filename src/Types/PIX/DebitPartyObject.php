<?php

namespace WeDevBr\Celcoin\Types\PIX;

use WeDevBr\Celcoin\Types\Data;

class DebitPartyObject extends Data
{
    public string $Account;

    public string $Bank;

    public string $Branch;

    public string $PersonType;

    public string $TaxId;

    public string $AccountType;

    public string $Name;

    public function __construct(array $data = [])
    {
        parent::__construct($data);
    }
}
