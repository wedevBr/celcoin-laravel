<?php

namespace WeDevBr\Celcoin\Rules\Topups;

class Create
{
    public static function rules()
    {
        return [
            'externalTerminal' => ['required', 'string'],
            'externalNsu' => ['required', 'integer'],
            'topupData' => ['required', 'array'],
            'topupData.value' => ['required', 'decimal:0,2'],
            'cpfCnpj' => ['required', 'string'],
            'signerCode' => ['nullable', 'string'],
            'providerId' => ['required', 'numeric'],
            'phone' => ['required', 'array'],
            'phone.stateCode' => ['required', 'numeric'],
            'phone.countryCode' => ['required', 'numeric'],
            'phone.number' => ['required', 'string'],
        ];
    }
}
