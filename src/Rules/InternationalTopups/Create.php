<?php

namespace WeDevBr\Celcoin\Rules\InternationalTopups;

class Create
{
    public static function rules()
    {
        return [
            'externalTerminal' => ['required', 'string'],
            'externalNsu' => ['required', 'integer'],
            'cpfCnpj' => ['required', 'string'],
            'phone' => ['required', 'array'],
            'phone.number' => ['required', 'string'],
            'phone.countryCode' => ['required', 'integer'],
            'phone.stateCode' => ['nullable', 'integer'],
            'value' => ['required', 'decimal:0,4'],
            'topupProductId' => ['required', 'string'],
        ];
    }
}
