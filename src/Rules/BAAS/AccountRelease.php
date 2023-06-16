<?php

namespace WeDevBr\Celcoin\Rules\BAAS;

class AccountRelease
{
    public static function rules()
    {
        return [
            "clientCode" => ['nullable', 'string'],
            "amount" => ['nullable', 'numeric'],
            "type" => ['nullable', 'in:Crédito,Débito'],
            "description" => ['nullable', 'string'],
        ];
    }
}
