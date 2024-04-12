<?php

namespace WeDevBr\Celcoin\Types\Topups;

use WeDevBr\Celcoin\Types\Data;

class Create extends Data
{
    public string $externalTerminal;

    public int $externalNsu;

    public TopupData $topupData;

    public string $cpfCnpj;

    public ?string $signerCode;

    public int $providerId;

    public Phone $phone;

    public function __construct(array $data = [])
    {
        $data['topupData'] = new TopupData($data['topupData'] ?? []);
        $data['phone'] = new Phone($data['phone'] ?? []);
        parent::__construct($data);
    }
}
