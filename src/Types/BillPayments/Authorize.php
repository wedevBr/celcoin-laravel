<?php

namespace WeDevBr\Celcoin\Types\BillPayments;

use WeDevBr\Celcoin\Types\Data;

class Authorize extends Data
{
    public string $document;

    public ?string $externalTerminal;

    public ?int $externalNSU;

    public BarCode $barCode;

    public function __construct(array $data = [])
    {
        $data['barCode'] = new BarCode($data['barCode'] ?? []);
        parent::__construct($data);
    }
}
