<?php

namespace WeDevBr\Celcoin\Rules\BankTransfer;

class Create
{
    public static function rules()
    {
        return [
            "document" => ['required', 'string'],
            "externalTerminal" => ['nullable', 'string'],
            "externalNSU" => ['nullable', 'numeric'],
            "accountCode" => ['nullable', 'string'],
            "digitCode" => ['nullable', 'string'],
            "branchCode" => ['nullable', 'string'],
            "institutionCode" => ['nullable', 'numeric'],
            "name" => ['nullable', 'string'],
            "value" => ['required', 'decimal:0,2'],
            "bankAccountType" => ['nullable', 'in:CC,CP'],
            "institutionIspb" => ['required', 'string']
        ];
    }
}
