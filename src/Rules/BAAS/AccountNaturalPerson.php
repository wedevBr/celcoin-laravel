<?php

namespace WeDevBr\Celcoin\Rules\BAAS;

class AccountNaturalPerson
{
    public static function rules()
    {
        return [
            "clientCode" => ['required', 'string'],
            "accountOnboardingType" => ['required', 'in:BANKACCOUNT'],
            "documentNumber" => ['required', 'string'],
            "phoneNumber" => ['required', 'string'],
            "email" => ['required', 'string'],
            "motherName" => ['required', 'string'],
            "fullName" => ['required', 'string'],
            "socialName" => ['required', 'string'],
            "birthDate" => ['required', 'string'],
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
