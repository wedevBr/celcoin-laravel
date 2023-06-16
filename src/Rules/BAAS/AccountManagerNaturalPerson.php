<?php

namespace WeDevBr\Celcoin\Rules\BAAS;

class AccountManagerNaturalPerson
{
    public static function rules()
    {
        return [
            "phoneNumber" => ['required', 'string'],
            "email" => ['required', 'string'],
            "socialName" => ['required', 'string'],
            "address" => ['required', 'array'],
            "address.postalCode" => ['required', 'string'],
            "address.street" => ['required', 'string'],
            "address.number" => ['nullable', 'string'],
            "address.addressComplement" => ['nullable', 'string'],
            "address.neighborhood" => ['required', 'string'],
            "address.city" => ['required', 'string'],
            "address.state" => ['required', 'string'],
            "address.longitude" => ['nullable', 'string'],
            "address.latitude" => ['nullable', 'string'],
            "isPoliticallyExposedPerson" => ['required', 'boolean']
        ];
    }
}
