<?php

namespace WeDevBr\Celcoin\Types\BAAS;

use WeDevBr\Celcoin\Enums\AccountOnboardingTypeEnum;
use WeDevBr\Celcoin\Types\Data;

class AccountNaturalPerson extends Data
{
    public string $clientCode;

    public AccountOnboardingTypeEnum $accountOnboardingType;

    public string $documentNumber;

    public string $phoneNumber;

    public string $email;

    public string $motherName;

    public string $fullName;

    public string $socialName;

    public string $birthDate;

    public Address $address;

    public bool $isPoliticallyExposedPerson;

    public function __construct(array $data = [])
    {
        $data['address'] = new Address($data['address'] ?? []);
        parent::__construct($data);
    }
}
