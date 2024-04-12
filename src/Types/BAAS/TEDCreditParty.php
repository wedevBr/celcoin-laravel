<?php

namespace WeDevBr\Celcoin\Types\BAAS;

use WeDevBr\Celcoin\Enums\AccountTypeEnum;
use WeDevBr\Celcoin\Enums\PersonTypeEnum;
use WeDevBr\Celcoin\Types\Data;

class TEDCreditParty extends Data
{
    public string $bank;

    public string $account;

    public string $branch;

    public string $taxId;

    public string $name;

    public AccountTypeEnum $accountType;

    public PersonTypeEnum $personType;

    public function __construct(array $data = [])
    {
        parent::__construct($data);
    }
}
