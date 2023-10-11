<?php

namespace WeDevBr\Celcoin\Rules\PIX;

class DynamicQRCreate
{
    /**
     * @return array[]
     */
    public static function rules(): array
    {
        return [
            'clientRequestId' => ['required'],
            'key' => ['required'],
            'amount' => ['required', 'decimal:2'],
            'payerCpf' => ['required_without:payerCnpj'],
            'payerCnpj' => ['required_without:payerCpf'],
            'payerQuestion' => ['sometimes'],
            'payerName' => ['required', 'string'],
            'merchant' => ['required', 'array'],
            'merchant.name' => ['required', 'string', 'max:25'],
            'merchant.city' => ['required', 'string'],
            'merchant.postalCode' => ['required', 'string'],
            'merchant.merchantCategoryCode' => ['required', 'string', 'min:3', 'max:4'],
            'additionalInformation' => ['sometimes', 'required', 'array'],
            'additionalInformation.*.value' => ['required_with:additionalInformation.*.key', 'string'],
            'additionalInformation.*.key' => ['required_with:additionalInformation.*.value', 'string'],
            'expiration' => ['required', 'integer'],
        ];
    }
}
