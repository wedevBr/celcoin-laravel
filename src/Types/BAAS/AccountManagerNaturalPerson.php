<?php

namespace WeDevBr\Celcoin\Types\BAAS;

use WeDevBr\Celcoin\Types\Data;

class AccountManagerNaturalPerson extends Data
{

    public string $phoneNumber;
    public string $email;
    public string $socialName;
    public Address $address;
    public bool $isPoliticallyExposedPerson;

    public function __construct(array $data = [])
    {
        $data['address'] = new Address($data['address'] ?? []);
        parent::__construct($data);
    }
}
