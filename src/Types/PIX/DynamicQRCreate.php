<?php

namespace WeDevBr\Celcoin\Types\PIX;

use WeDevBr\Celcoin\Types\Data;

class DynamicQRCreate extends Data
{
    public string $clientRequestId;

    public string $key;

    public string $amount;

    public Merchant $merchant;

    public string $payerCpf;

    public string $payerCnpj;

    public string $payerQuestion;

    public string $payerName;

    /**
     * @var AdditionalInformation[]
     */
    public array $additionalInformation;

    public int $expiration;

    public function __construct(array $data = [])
    {
        parent::__construct($data);
    }
}
