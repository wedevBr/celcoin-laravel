<?php

namespace WeDevBr\Celcoin\Types\BAAS;

use WeDevBr\Celcoin\Types\Data;

class TEDCreditParty extends Data
{

    public string $bank;
    public string $account;
    public string $branch;
    public string $taxId;
    public string $name;
    public string $accountType;
    public string $personType;

    public function __construct(array $data = [])
    {
        parent::__construct($data);
    }
}
