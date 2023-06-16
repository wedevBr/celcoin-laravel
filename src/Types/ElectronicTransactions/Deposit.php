<?php

namespace WeDevBr\Celcoin\Types\ElectronicTransactions;

use WeDevBr\Celcoin\Types\Data;

class Deposit extends Data
{
    public ?int $externalNSU;
    public ?string $externalTerminal;
    public string $payerContact;
    public string $payerDocument;
    public string $transactionIdentifier;
    public string $payerName;
    public string $namePartner = 'TECBAN_BANCO24H';
    public string $value;

    public function __construct(array $data = [])
    {
        $data['namePartner'] =  $data[''] ?? 'TECBAN_BANCO24H';
        parent::__construct($data);
    }
}
