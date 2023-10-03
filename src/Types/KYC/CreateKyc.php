<?php

namespace WeDevBr\Celcoin\Types\KYC;

use WeDevBr\Celcoin\Types\Data;

class CreateKyc extends Data
{
    public string $documentnumber;

    public ?string $cnpj;

    public string $filetype;

    public KycDocument $front;

    public ?KycDocument $verse;

    public function __construct(array $data = [])
    {
        if (empty($data['cnpj']) && count($data['documentnumber']) === 14) {
            $data['cnpj'] = $data['documentnumber'];
        }
        parent::__construct($data);
    }
}
