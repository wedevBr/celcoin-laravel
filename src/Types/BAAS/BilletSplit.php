<?php

namespace WeDevBr\Celcoin\Types\BAAS;

use WeDevBr\Celcoin\Types\Data;

class BilletSplit extends Data
{
    public string $account;

    public string $document;

    public ?float $percent;

    public ?float $amount;

    public bool $aggregatePayment = false;

    public function __construct(array $data = [])
    {
        parent::__construct($data);
    }
}
