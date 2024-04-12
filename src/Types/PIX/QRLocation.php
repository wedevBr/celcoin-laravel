<?php

namespace WeDevBr\Celcoin\Types\PIX;

use WeDevBr\Celcoin\Types\Data;

class QRLocation extends Data
{
    public string $clientRequestId;

    public string $type;

    public Merchant $merchant;

    public function __construct(array $data = [])
    {
        parent::__construct($data);
    }
}
