<?php

namespace WeDevBr\Celcoin\Rules\BAAS;

class BAASTEFTransfer
{
    public static function rules(): array
    {
        return [
            'amount' => ['required', 'decimal:0,2', 'min:0.01'],
            'clientRequestId' => ['required', 'string', 'max:200'],
            'debitParty' => ['required', 'array'],
            'debitParty.account' => ['required', 'string'],
            'creditParty' => ['required', 'array'],
            'creditParty.account' => ['required', 'string', 'different:debitParty.account'],
            'description' => ['sometimes', 'string'],
        ];
    }
}
