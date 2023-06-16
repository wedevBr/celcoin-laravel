<?php

namespace WeDevBr\Celcoin\Types\BAAS;

use WeDevBr\Celcoin\Enums\AccountOnboardingTypeEnum;
use WeDevBr\Celcoin\Types\Data;

class AccountBusiness extends Data
{

    public string $clientCode;
    public AccountOnboardingTypeEnum $accountOnboardingType;
    public string $documentNumber;
    public string $contactNumber;
    public string $businessEmail;
    public string $businessName;
    public string $tradingName;
    // /** @var Owner[] */
    public ?array $owner;
    public ?Address $businessAddress;


    public function __construct(array $data = [])
    {
        $data['owner'] = is_array($data['owner'] ?? null)
            ? array_map(fn ($owner) => new Owner(is_array($owner) ? $owner : []), $data['owner'])
            : null;
        // $data['owner'] = new Owner($data['owner'] ?? []);
        $data['businessAddress'] = new Address($data['businessAddress'] ?? []);
        parent::__construct($data);
    }
}
