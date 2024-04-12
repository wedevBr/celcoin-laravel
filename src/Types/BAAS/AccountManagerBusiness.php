<?php

namespace WeDevBr\Celcoin\Types\BAAS;

use WeDevBr\Celcoin\Types\Data;

class AccountManagerBusiness extends Data
{
    public string $contactNumber;

    public string $businessEmail;

    public string $teste;

    /** @var Owner[] */
    public array $owners;

    public Address $businessAddress;

    public function __construct(array $data = [])
    {
        $data['owners'] = is_array($data['owners'] ?? null)
            ? array_map(fn ($owner) => new Owner(is_array($owner) ? $owner : []), $data['owners'])
            : [];
        $data['businessAddress'] = new Address($data['businessAddress'] ?? []);
        parent::__construct($data);
    }
}
