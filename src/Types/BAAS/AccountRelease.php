<?php

namespace WeDevBr\Celcoin\Types\BAAS;

use WeDevBr\Celcoin\Enums\TypeReleaseEnum;
use WeDevBr\Celcoin\Types\Data;

class AccountRelease extends Data
{
    public string $clientCode;
    public float $amount;
    public TypeReleaseEnum $type;
    public ?string $description;

    public function __construct(array $data = [])
    {
        parent::__construct($data);
    }
}
