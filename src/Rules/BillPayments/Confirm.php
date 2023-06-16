<?php

namespace WeDevBr\Celcoin\Rules\BillPayments;

class Confirm
{
    public static function rules()
    {
        return [
            "externalNSU" => ['nullable', 'numeric'],
            "externalTerminal" => ['nullable', 'string'],
        ];
    }
}
