<?php

namespace WeDevBr\Celcoin\Rules\Topups;

class Providers
{
    public static function rules()
    {
        return [
            "stateCode" => ['nullable', 'numeric'],
            "type" => ['nullable', 'in:0,1,2'],
            "category" =>  ['nullable', 'in:0,1,2,3,4,5'],
        ];
    }
}
