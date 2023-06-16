<?php

namespace WeDevBr\Celcoin\Rules\Topups;

class Create
{
    public static function rules()
    {
        return [
            'externalTerminal' => ['nullable', 'string'],
            'externalNsu' => ['nullable', 'numeric'],
            'topupData' => ['nullable', 'array'],
            'topupData.value' => ['nullable', 'numeric'],
            'cpfCnpj' => ['required', 'string'],
            'signerCode' => ['nullable', 'string'],
            'providerId' => ['required', 'numeric'],
            'phone' => ['required', 'array'],
            'phone.stateCode' => ['required', 'numeric'],
            'phone.countryCode' => ['required', 'numeric'],
            'phone.number' => ['required', 'string']
        ];
    }
}
