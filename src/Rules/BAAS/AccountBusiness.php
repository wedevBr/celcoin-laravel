<?php

namespace WeDevBr\Celcoin\Rules\BAAS;

use Illuminate\Validation\Rule;
use WeDevBr\Celcoin\Enums\AccountOnboardingTypeEnum;

class AccountBusiness
{
    public static function rules()
    {
        return [
            "clientCode" => ['required', 'string'],
            "accountOnboardingType" => ['required', Rule::in(array_column(AccountOnboardingTypeEnum::cases(), 'value'))],
            "documentNumber" => ['required', 'max_digits:14'],
            "contactNumber" => ['required', 'starts_with:+', 'regex:/(\+55)\d{10,11}/'],
            "businessEmail" => ['required', 'email'],
            "businessName" => ['required', 'string'],
            "tradingName" => ['required', 'string'],
            "owner" => ['nullable', 'array'],
            "owner.*.documentNumber" => ['required', 'max_digits:11'],
            "owner.*.fullName" => ['required', 'string'],
            "owner.*.phoneNumber" => ['required', 'starts_with:+', 'regex:/(\+55)\d{10,11}/'],
            "owner.*.email" => ['required', 'email'],
            "owner.*.motherName" => ['required', 'string'],
            "owner.*.socialName" => ['nullable', 'string'],
            "owner.*.birthDate" => ['required', 'date_format:d-m-Y'],
            "owner.*.address" => ['nullable', 'array'],
            "owner.*.address.postalCode" => ['required', 'digits:8'],
            "owner.*.address.street" => ['required', 'string'],
            "owner.*.address.number" => ['nullable', 'string'],
            "owner.*.address.addressComplement" => ['nullable', 'string'],
            "owner.*.address.neighborhood" => ['required', 'string'],
            "owner.*.address.city" => ['required', 'string'],
            "owner.*.address.state" => ['required', 'string'],
            "owner.*.address.longitude" => ['nullable', 'string'],
            "owner.*.address.latitude" => ['nullable', 'string'],
            "owner.*.isPoliticallyExposedPerson" => ['required', 'boolean'],
            "businessAddress" => ['nullable', 'array'],
            "businessAddress.postalCode" => ['required', 'digits:8'],
            "businessAddress.street" => ['required', 'string'],
            "businessAddress.number" => ['nullable', 'string'],
            "businessAddress.addressComplement" => ['nullable', 'string'],
            "businessAddress.neighborhood" => ['required', 'string'],
            "businessAddress.city" => ['required', 'string'],
            "businessAddress.state" => ['required', 'string'],
            "businessAddress.longitude" => ['nullable', 'string'],
            "businessAddress.latitude" => ['nullable', 'string'],
        ];
    }
}
