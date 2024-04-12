<?php

namespace WeDevBr\Celcoin\Types\PIX;

use WeDevBr\Celcoin\Enums\ClaimKeyTypeEnum;
use WeDevBr\Celcoin\Enums\ClaimTypeEnum;
use WeDevBr\Celcoin\Types\Data;

class Claim extends Data
{
    public string $key;

    public ClaimKeyTypeEnum $keyType;

    public string $account;

    public ClaimTypeEnum $claimType;

    public function __construct(array $data)
    {
        parent::__construct($data);
        $this->claimType = ClaimTypeEnum::from($data['claimType']);
    }
}
