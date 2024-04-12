<?php

namespace WeDevBr\Celcoin\Types\DDA;

use WeDevBr\Celcoin\Types\Data;

class RemoveUser extends Data
{
    public string $document;

    public ?string $clientRequestId;

    public function __construct(array $data = [])
    {
        parent::__construct($data);
    }
}
