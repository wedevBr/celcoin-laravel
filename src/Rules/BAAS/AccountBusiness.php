<?php

namespace WeDevBr\Celcoin\Rules\BAAS;

class AccountBusiness
{
    public static function rules()
    {
        return [
            "clientCode" => ['required', 'string'],
            "accountOnboardingType" => ['required', 'in:BANKACCOUNT'],
            "documentNumber" => ['required', 'string'],
            "contactNumber" => ['required', 'string'],
            "businessEmail" => ['required', 'string'],
            "businessName" => ['required', 'string'],
            "tradingName" => ['required', 'string'],
            "owner" => ['nullable', 'array'],
            "owner.*.documentNumber" => ['required', 'string'],
            "owner.*.fullName" => ['required', 'string'],
            "owner.*.phoneNumber" => ['required', 'string'],
            "owner.*.email" => ['required', 'string'],
            "owner.*.motherName" => ['required', 'string'],
            "owner.*.socialName" => ['nullable', 'string'],
            "owner.*.birthDate" => ['required', 'string'],
            "owner.*.address" => ['nullable', 'array'],
            "owner.*.address.postalCode" => ['required', 'string'],
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
            "businessAddress.postalCode" => ['required', 'string'],
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
