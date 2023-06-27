<?php

namespace WeDevBr\Celcoin\Types\PIX;

use WeDevBr\Celcoin\Types\Data;

class QRStaticPayment extends Data
{
    public string $key;
    public string $transactionIdentification;
    public string $additionalInformation;

    public float $amount;
    /**
     * @var array<string>
     */
    public array $tags;
    public Merchant $merchant;

    /**
     * @param array $data
     */
    public function __construct(array $data = [])
    {
        parent::__construct($data);
    }
}
