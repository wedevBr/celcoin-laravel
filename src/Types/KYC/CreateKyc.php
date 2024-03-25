<?php

namespace WeDevBr\Celcoin\Types\KYC;

use WeDevBr\Celcoin\Enums\KycDocumentEnum;
use WeDevBr\Celcoin\Interfaces\Attachable;
use WeDevBr\Celcoin\Types\Data;

class CreateKyc extends Data
{
    public string $documentnumber;

    public ?string $cnpj;

    public KycDocumentEnum $filetype;

    public function __construct(array $data = [])
    {
        parent::__construct($data);
    }

    public function toArray(): array
    {
        $array = parent::toArray();

        return array_filter($array);
    }
}
