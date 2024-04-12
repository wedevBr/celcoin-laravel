<?php

namespace WeDevBr\Celcoin\Types\BAAS;

use WeDevBr\Celcoin\Enums\ClientFinalityEnum;
use WeDevBr\Celcoin\Types\Data;

class TEDTransfer extends Data
{
    public float $amount;

    public string $clientCode;

    public DebitParty $debitParty;

    public TEDCreditParty $creditParty;

    public ClientFinalityEnum $clientFinality;

    public ?string $description;

    public function __construct(array $data = [])
    {
        $data['debitParty'] = new DebitParty($data['debitParty'] ?? []);
        $data['creditParty'] = new TEDCreditParty($data['creditParty'] ?? []);
        parent::__construct($data);
    }
}
