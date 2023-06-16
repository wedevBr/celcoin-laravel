<?php

namespace WeDevBr\Celcoin\Types\BankTransfer;;

use WeDevBr\Celcoin\Types\Data;

class Create extends Data
{
    public string $document;
    public ?string $externalTerminal;
    public ?int $externalNSU;
    public ?string $accountCode;
    public ?string $digitCode;
    public ?string $branchCode;
    public ?int $institutionCode;
    public ?string $name;
    public float $value;
    public ?string $bankAccountType;
    public string $institutionIspb;

    public function __construct(array $data = [])
    {
        parent::__construct($data);
    }
}
