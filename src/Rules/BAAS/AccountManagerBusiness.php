<?php

namespace WeDevBr\Celcoin\Rules\BAAS;

class AccountManagerBusiness
{
    public static function rules()
    {
        return [
            "businessEmail" => ['required', 'email'],
            "contactNumber" => ['required', 'starts_with:+', 'regex:/(\+55)\d{10,11}/'],
            "owners" => ['nullable', 'array'],
            "owners.*.documentNumber" => ['required', 'max_digits:11'],
            "owners.*.fullName" => ['required', 'string'],
            "owners.*.phoneNumber" => ['required', 'starts_with:+', 'regex:/(\+55)\d{10,11}/'],
            "owners.*.email" => ['required', 'email'],
            "owners.*.motherName" => ['required', 'string'],
            "owners.*.socialName" => ['nullable', 'string'],
            "owners.*.birthDate" => ['required', 'date_format:d-m-Y'],
            "owners.*.address" => ['nullable', 'array'],
            "owners.*.address.postalCode" => ['required', 'digits:8'],
            "owners.*.address.street" => ['required', 'string'],
            "owners.*.address.number" => ['nullable', 'string'],
            "owners.*.address.addressComplement" => ['nullable', 'string'],
            "owners.*.address.neighborhood" => ['required', 'string'],
            "owners.*.address.city" => ['required', 'string'],
            "owners.*.address.state" => ['required', 'string'],
            "owners.*.address.longitude" => ['nullable', 'string'],
            "owners.*.address.latitude" => ['nullable', 'string'],
            "owners.*.isPoliticallyExposedPerson" => ['required', 'boolean'],
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
