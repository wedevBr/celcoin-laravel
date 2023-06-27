<?php

namespace WeDevBr\Celcoin\Rules\ElectronicTransactions;

class WithdrawToken
{
    public static function rules()
    {
        return [
            'externalNSU' => ['nullable', 'numeric'],
            'externalTerminal' => ['nullable', 'string'],
            'receivingDocument' => ['required', 'string'],
            'receivingName' => ['required', 'string'],
            'value' => ['required', 'regex:/\d{1,10}\.\d{2}/'],
        ];
    }
}
