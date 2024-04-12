<?php

namespace WeDevBr\Celcoin\Types\ElectronicTransactions;

use WeDevBr\Celcoin\Types\Data;

class WithdrawToken extends Data
{
    public ?int $externalNSU;

    public ?string $externalTerminal;

    public string $receivingDocument;

    public string $receivingName;

    public string $value;

    public function __construct(array $data = [])
    {
        parent::__construct($data);
    }
}
