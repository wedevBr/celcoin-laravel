<?php

namespace WeDevBr\Celcoin\Types\DDA;

use WeDevBr\Celcoin\Types\Data;

class RegisterInvoice extends Data
{
    public array $document;

    public function __construct(array $data = [])
    {
        parent::__construct($data);
    }
}
