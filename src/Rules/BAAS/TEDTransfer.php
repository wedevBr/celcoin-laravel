<?php

namespace WeDevBr\Celcoin\Rules\BAAS;

use WeDevBr\Celcoin\Enums\ClientFinalityEnum;

class TEDTransfer
{
    public static function rules()
    {
        return [
            'amount' => ['required', 'regex:/\d{1,10}\.\d{2}/'],
            'clientCode' => ['required', 'string'],
            'debitParty' => ['required', 'array'],
            'debitParty.account' => ['required', 'string'],
            'creditParty' => ['required', 'array'],
            'creditParty.bank' => ['required', 'string'],
            'creditParty.account' => ['required', 'string'],
            'creditParty.branch' => ['required', 'string'],
            'creditParty.taxId' => ['required', 'string'],
            'creditParty.name' => ['required', 'string'],
            'creditParty.accountType' => ['required', 'string'],
            'creditParty.personType' => ['required', 'string'],
            'clientFinality' => ['required', 'string'],
            'description' => ['some', 'required_if:clientFinality,' . ClientFinalityEnum::OTHERS->value, 'string'],
        ];
    }
}
