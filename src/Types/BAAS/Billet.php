<?php

namespace WeDevBr\Celcoin\Types\BAAS;

use WeDevBr\Celcoin\Types\Data;

class Billet extends Data
{
    public string $externalId;

    public int $expirationAfterPayment;

    public string $dueDate;

    public float $amount;

    public BilletDebtor $debtor;

    public BilletReceiver $receiver;

    public ?BilletInstruction $instructions;

    /**
     * @var array<BilletSplit | null>
     */
    public ?array $split;

    public function __construct(array $data = [])
    {
        parent::__construct($data);
    }
}
