<?php

namespace WeDevBr\Celcoin\Rules\KYC;

class CreateKycRule
{
    public static function rules()
    {
        return [
            'documentnumber' => ['required', 'digits:11,14'],
            'filetype' => ['required', 'in:RG,CNH,RNE,CARTAO_CNPJ,CONTRATO_SOCIAL,BALANCO,FATURAMENTO,KYC_EXTERNO'],
            'front' => ['required', 'file'],
            'verse' => ['sometimes', 'file'],
            'cnpj' => ['sometimes', 'same:documentnumber', 'digits:11,14'],
        ];
    }
}
