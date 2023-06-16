<?php

namespace WeDevBr\Celcoin\Types\DDA;

use WeDevBr\Celcoin\Types\Data;

class RegisterUser extends Data
{
    public string $document;
    public string $clientName;
    public ?string $clientRequestId;

    public function __construct(array $data = [])
    {
        parent::__construct($data);
    }
}
