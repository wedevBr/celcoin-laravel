<?php

namespace WeDevBr\Celcoin\Types\PIX;

use WeDevBr\Celcoin\Types\Data;

class Receiver extends Data
{
    public string $name;

    public string $cpf;

    public string $cnpj;

    public string $postalCode;

    public string $city;

    public string $publicArea;

    public string $state;

    public string $fantasyName;

    public function __construct(array $data = [])
    {
        parent::__construct($data);
    }
}
