<?php

namespace WeDevBr\Celcoin\Types\BillPayments;

use WeDevBr\Celcoin\Types\Data;

class InfoBearer extends Data
{
    public ?string $nameBearer;
    public ?string $documentBearer;
    public ?int $methodPaymentCode;

    public function __construct(array $data = [])
    {
        parent::__construct($data);
    }
}
