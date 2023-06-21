<?php

namespace WeDevBr\Celcoin\Rules\BAAS;

class TEDTransfer
{
    public static function rules()
    {
        return [
            'amount' => ['required', 'numeric'],
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
            'description' => ['nullable', 'string'],
        ];
    }
}
