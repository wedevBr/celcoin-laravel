<?php

namespace WeDevBr\Celcoin\Types\BAAS;

use WeDevBr\Celcoin\Types\Data;

class Owner extends Data
{
    public string $documentNumber;

    public string $fullName;

    public string $phoneNumber;

    public string $email;

    public string $motherName;

    public ?string $socialName;

    public string $birthDate;

    public ?Address $address;

    public bool $isPoliticallyExposedPerson;

    public function __construct(array $data = [])
    {
        $data['address'] = new Address($data['address'] ?? []);
        parent::__construct($data);
    }
}
