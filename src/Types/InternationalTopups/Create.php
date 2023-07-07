<?php

namespace WeDevBr\Celcoin\Types\InternationalTopups;

use WeDevBr\Celcoin\Types\Data;

class Create extends Data
{
    public string $externalTerminal;
    public int $externalNsu;
    public string $cpfCnpj;
    public Phone $phone;
    public string $value;
    public string $topupProductId;

    public function __construct(array $data = [])
    {
        $data['phone'] = new Phone($data['phone'] ?? []);
        parent::__construct($data);
    }
}
