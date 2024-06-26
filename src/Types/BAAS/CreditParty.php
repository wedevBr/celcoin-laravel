<?php

namespace WeDevBr\Celcoin\Types\BAAS;

use WeDevBr\Celcoin\Enums\CreditPartyAccountTypeEnum;
use WeDevBr\Celcoin\Types\Data;

class CreditParty extends Data
{
    public string $bank;

    public ?string $key;

    public string $account;

    public string $branch;

    public string $taxId;

    public string $name;

    public CreditPartyAccountTypeEnum $accountType;

    public function __construct(array $data = [])
    {
        parent::__construct($data);
    }
}
