<?php

namespace WeDevBr\Celcoin\Rules\BAAS;

use Illuminate\Validation\Rule;
use WeDevBr\Celcoin\Enums\AccountOnboardingTypeEnum;

class AccountNaturalPerson
{
    public static function rules()
    {
        return [
            "clientCode" => ['required', 'string'],
            "accountOnboardingType" => ['required', Rule::in(array_column(AccountOnboardingTypeEnum::cases(), 'value'))],
            "documentNumber" => ['required', 'max_digits:11'],
            "phoneNumber" => ['required', 'starts_with:+', 'regex:/(\+55)\d{10,11}/'],
            "email" => ['required', 'email'],
            "motherName" => ['required', 'string'],
            "fullName" => ['required', 'string'],
            "socialName" => ['required', 'string'],
            "birthDate" => ['required', 'date_format:d-m-Y'],
            "address" => ['required', 'array'],
            "address.postalCode" => ['required', 'digits:8'],
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
