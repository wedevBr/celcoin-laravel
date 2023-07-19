<?php

namespace WeDevBr\Celcoin\Types\PIX;

use WeDevBr\Celcoin\Types\Data;

class PaymentInit extends Data
{
    public float $amount;
    public float $vlcpAmount;
    public float $vldnAmount;
    public string $withdrawalServiceProvider;
    public string $withdrawalAgentMode;
    public string $clientCode;
    public string $transactionIdentification;
    public string $endToEndId;
    public DebitPartyObject $debitParty;
    public CreditPartyObject $creditParty;
    public string $initiationType;
    public string $taxIdPaymentInitiator;
    public string $remittanceInformation;
    public string $paymentType;
    public string $urgency;
    public string $transactionType;

    /**
     * @param array $data
     */
    public function __construct(array $data = [])
    {
        parent::__construct($data);
    }
}
