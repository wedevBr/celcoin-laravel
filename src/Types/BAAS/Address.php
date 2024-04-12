<?php

namespace WeDevBr\Celcoin\Types\BAAS;

use WeDevBr\Celcoin\Types\Data;

class Address extends Data
{
    public string $postalCode;

    public string $street;

    public ?string $number;

    public ?string $addressComplement;

    public string $neighborhood;

    public string $city;

    public string $state;

    public ?string $longitude;

    public ?string $latitude;

    public function __construct(array $data = [])
    {
        parent::__construct($data);
    }
}
