<?php

namespace WeDevBr\Celcoin\Types\ElectronicTransactions;

use WeDevBr\Celcoin\Types\Data;

class Withdraw extends Data
{
    public ?int $externalNSU;

    public ?string $externalTerminal;

    public string $receivingContact;

    public string $receivingDocument;

    public string $transactionIdentifier;

    public string $receivingName;

    public string $namePartner;

    public string $value;

    public ?SecondAuthenticationData $secondAuthentication;

    public function __construct(array $data = [])
    {
        $data['secondAuthentication'] = new SecondAuthenticationData($data['secondAuthentication'] ?? []);
        parent::__construct($data);
    }
}
