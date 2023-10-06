<?php

namespace WeDevBr\Celcoin\Types\BAAS;

use WeDevBr\Celcoin\Enums\ClientFinalityEnum;
use WeDevBr\Celcoin\Types\Data;
use WeDevBr\Celcoin\Types\PIX\Debtor;

class BilletDebtor extends Data
{
    public string $name;
    public string $document;
    public string $postalCode;
    public string $publicArea;
    public string $number;
    public ?string $complement;
    public string $neighborhood;
    public string $city;
    public string $state;

    public function __construct(array $data = [])
    {
        parent::__construct($data);
    }
}
