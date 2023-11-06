<?php

namespace WeDevBr\Celcoin\Types\BAAS;

use WeDevBr\Celcoin\Types\BillPayments\BarCode;
use WeDevBr\Celcoin\Types\Data;

class BillPayment extends Data
{
    public string $clientRequestId;

    public float $amount;

    public string $account;

    public int $transactionIdAuthorize;

    /**
     * @var array<int, Tag>|null
     */
    public ?array $tags;

    public BarCode $barCodeInfo;

    public function __construct(array $data = [])
    {
        parent::__construct($data);
    }
}