<?php

namespace WeDevBr\Celcoin\Types\BAAS;

use WeDevBr\Celcoin\Enums\InitiationTypeEnum;
use WeDevBr\Celcoin\Enums\PaymentTypeEnum;
use WeDevBr\Celcoin\Enums\TransactionTypeEnum;
use WeDevBr\Celcoin\Enums\UrgencyEnum;
use WeDevBr\Celcoin\Types\Data;

class PixCashOut extends Data
{
    public float $amount;
    public string $clientCode;
    public ?string $transactionIdentification;
    public ?string $endToEndId;
    public InitiationTypeEnum $initiationType;
    public PaymentTypeEnum $paymentType;
    public UrgencyEnum $urgency;
    public TransactionTypeEnum $transactionType;
    public DebitParty $debitParty;
    public CreditParty $creditParty;
    public ?string $remittanceInformation;

    public function __construct(array $data = [])
    {
        $data['debitParty'] = new DebitParty($data['debitParty'] ?? []);
        $data['creditParty'] = new CreditParty($data['creditParty'] ?? []);
        parent::__construct($data);
    }
}
