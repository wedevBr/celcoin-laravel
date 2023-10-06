<?php

namespace WeDevBr\Celcoin\Types\BAAS;

use WeDevBr\Celcoin\Types\Data;

class Billet extends Data
{
    public string $externalId;
    public ?string $merchantCategoryCode;
    public int $expirationAfterPayment;
    public string $duedate;
    public float $amount;
    public ?string $key;
    /**
     * @var BilletDebtor
     */
    public BilletDebtor $debtor;
    /**
     * @var BilletReceiver
     */
    public BilletReceiver $receiver;
    /**
     * @var array<BilletInstruction | null>
     */
    public ?array $instructions;
    /**
     * @var array<BilletSplit | null>
     */
    public ?array $split;


    public function __construct(array $data = [])
    {
        parent::__construct($data);
    }
}
