<?php

namespace WeDevBr\Celcoin\Types\PIX;

use WeDevBr\Celcoin\Types\Data;

class QRStaticPayment extends Data
{
    public string $key;

    public string $transactionIdentification;

    public string $additionalInformation;

    public ?string $amount;

    /**
     * @var array<string>
     */
    public array $tags;

    public Merchant $merchant;

    public function __construct(array $data = [])
    {
        if (! empty($data['amount'])) {
            $data['amount'] = number_format($data['amount'], 2, '.', '');
        }
        parent::__construct($data);
    }
}
