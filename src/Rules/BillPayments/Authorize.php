<?php

namespace WeDevBr\Celcoin\Rules\BillPayments;

class Authorize
{
    public static function rules()
    {
        return [
            "externalTerminal" => ['nullable', 'string'],
            "externalNSU" => ['nullable', 'numeric'],
            "barCode" =>  ['required', 'array'],
            "barCode.type" =>  ['required', 'in:1,2'],
            "barCode.digitable" => ['nullable', 'string'],
            "barCode.barCode" => ['nullable', 'string']
        ];
    }
}
