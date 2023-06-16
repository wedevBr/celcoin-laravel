<?php

namespace WeDevBr\Celcoin\Rules\ElectronicTransactions;

class Withdraw
{
    public static function rules()
    {
        return [
            'externalNSU' => ['nullable', 'numeric'],
            'externalTerminal' => ['nullable', 'string'],
            'receivingContact' => ['required', 'string'],
            'receivingDocument' => ['required', 'string'],
            'transactionIdentifier' => ['required', 'string'],
            'receivingName' => ['required', 'string'],
            'namePartner' => ['required', 'in:TECBAN_BANCO24H'],
            'value' => ['required', 'string'],
            'secondAuthentication' => ['nullable', 'array'],
            'secondAuthentication.dataForSecondAuthentication' => ['nullable', 'string'],
            'secondAuthentication.textForSecondIdentification' => ['nullable', 'string'],
            'secondAuthentication.useSecondAuthentication' => ['nullable', 'boolean'],
        ];
    }
}
