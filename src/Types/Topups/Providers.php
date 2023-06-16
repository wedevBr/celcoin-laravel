<?php

namespace WeDevBr\Celcoin\Types\Topups;

use WeDevBr\Celcoin\Types\Data;

class Providers extends Data
{
    public ?int $stateCode;
    public ?string $type;
    public ?string $category;

    public function __construct(array $data = [])
    {
        parent::__construct($data);
    }
}
