<?php

namespace WeDevBr\Celcoin\Types\BAAS;

use WeDevBr\Celcoin\Types\Data;

class TEFTransfer extends Data
{
    public float $amount;

    public string $clientRequestId;

    public Account $debitParty;

    public Account $creditParty;

    public ?string $description;

    public function __construct(array $data = [])
    {
        $data['debitParty'] = new Account($data['debitParty'] ?? []);
        $data['creditParty'] = new Account($data['creditParty'] ?? []);
        parent::__construct($data);
    }
}
