<?php

namespace WeDevBr\Celcoin\Types\BAAS;

use WeDevBr\Celcoin\Types\Data;

class PixCashOut extends Data
{
    public float $amount;
    public string $clientCode;
    public ?string $transactionIdentification;
    public ?string $endToEndId;
    public ?string $initiationType;
    public ?string $paymentType;
    public ?string $urgency;
    public ?string $transactionType;
    public ?DebitParty $debitParty;
    public ?CreditParty $creditParty;
    public ?string $remittanceInformation;

    public function __construct(array $data = [])
    {
        $data['debitParty'] = new DebitParty($data['debitParty'] ?? []);
        $data['creditParty'] = new CreditParty($data['creditParty'] ?? []);
        parent::__construct($data);
    }
}
