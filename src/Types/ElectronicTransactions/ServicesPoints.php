<?php

namespace WeDevBr\Celcoin\Types\ElectronicTransactions;

use WeDevBr\Celcoin\Types\Data;

class ServicesPoints extends Data
{
    public float $latitude;

    public float $longitude;

    public string $namePartner;

    public float $radius;

    public int $page;

    public int $size;

    public function __construct(array $data = [])
    {
        parent::__construct($data);
    }
}
