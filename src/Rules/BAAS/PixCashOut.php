<?php

namespace WeDevBr\Celcoin\Rules\BAAS;

class PixCashOut
{
    public static function rules()
    {
        return [
            'amount' => ['required', 'numeric'],
            'clientCode' => ['required', 'string'],
            'transactionIdentification' => ['nullable', 'string'],
            'endToEndId' => ['nullable', 'string'],
            'initiationType' => ['nullable', 'string'],
            'paymentType' => ['nullable', 'string'],
            'urgency' => ['nullable', 'string'],
            'transactionType' => ['nullable', 'string'],
            'debitParty' => ['nullable', 'array'],
            'debitParty.account' => ['required', 'string'],
            'creditParty' => ['nullable', 'array'],
            'creditParty.bank' => ['required', 'string'],
            'creditParty.key' => ['nullable', 'string'],
            'creditParty.account' => ['required', 'string'],
            'creditParty.branch' => ['required', 'string'],
            'creditParty.taxId' => ['required', 'string'],
            'creditParty.name' => ['required', 'string'],
            'creditParty.accountType' => ['required', 'string'],
            'remittanceInformation' => ['nullable', 'string'],
        ];
    }
}
