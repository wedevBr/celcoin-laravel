<?php

namespace WeDevBr\Celcoin\Types\Topups;

use WeDevBr\Celcoin\Types\Data;

class ProvidersValues extends Data
{
    public ?int $stateCode;
    public ?string $providerId;

    public function __construct(array $data = [])
    {
        parent::__construct($data);
    }
}
