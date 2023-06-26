<?php

namespace WeDevBr\Celcoin\Rules\ElectronicTransactions;

class Deposit
{
    public static function rules()
    {
        return [
            'externalNSU' => ['nullable', 'numeric'],
            'externalTerminal' => ['nullable', 'string'],
            'payerContact' => ['required', 'string'],
            'payerDocument' => ['required', 'string'],
            'transactionIdentifier' => ['required', 'string'],
            'payerName' => ['required', 'string'],
            'namePartner' => ['required', 'in:TECBAN_BANCO24H'],
            'value' => ['required', 'regex:/\d{1,10}\.\d{2}/'],
        ];
    }
}
