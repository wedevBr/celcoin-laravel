<?php

namespace WeDevBr\Celcoin\Types\KYC;

use WeDevBr\Celcoin\Enums\KycDocumentEnum;
use WeDevBr\Celcoin\Types\Data;

class CreateKyc extends Data
{
    public string $documentnumber;

    public ?string $cnpj;

    public KycDocumentEnum $filetype;

    public KycDocument $front;

    public ?KycDocument $verse = null;

    public function __construct(array $data = [])
    {
        if (empty($data['cnpj']) && strlen($data['documentnumber']) === 14) {
            $data['cnpj'] = $data['documentnumber'];
        }
        parent::__construct($data);
    }

    public function toArray(): array
    {
        $array = parent::toArray();

        if (!empty($array['front'])) {
            $array['front'] = $this->front->file;
        }

        if (!empty($array['verse'])) {
            $array['verse'] = $this->verse->file;
        }

        return array_filter($array);
    }
}
