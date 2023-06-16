<?php

namespace WeDevBr\Celcoin\Rules\InternationalTopups;

class Create
{
    public static function rules()
    {
        return [
            'externalTerminal' => ['nullable', 'string'],
            'externalNsu' => ['nullable', 'numeric'],
            'cpfCnpj' => ['nullable', 'string'],
            'phone' => ['required', 'array'],
            'phone.number' => ['required', 'string'],
            'phone.countryCode' => ['nullable', 'numeric'],
            'phone.stateCode' => ['nullable', 'numeric'],
            'value' => ['nullable', 'string'],
            'topupProductId' => ['nullable', 'string'],
        ];
    }
}
