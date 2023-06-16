<?php

namespace WeDevBr\Celcoin\Rules\BillPayments;

class Cancel
{
    public static function rules()
    {
        return [
            "externalNSU" => ['required', 'numeric'],
            "externalTerminal" => ['required', 'string'],
        ];
    }
}
