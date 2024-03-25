<?php

namespace WeDevBr\Celcoin\Rules\KYC;

use Illuminate\Validation\Rule;
use WeDevBr\Celcoin\Enums\KycDocumentEnum;

class CreateKycRule
{
    public static function rules(): array
    {
        return [
            'documentnumber' => ['required', 'digits:11,14'],
            'filetype' => ['required', Rule::enum(KycDocumentEnum::class)],
            'front' => ['sometimes',],
            'verse' => ['sometimes',],
            'cnpj' => ['sometimes', 'digits:11,14'],
        ];
    }
}
