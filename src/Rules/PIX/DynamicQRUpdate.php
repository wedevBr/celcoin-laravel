<?php

namespace WeDevBr\Celcoin\Rules\PIX;

class DynamicQRUpdate
{
    /**
     * @return array[]
     */
    public static function rules(): array
    {
        return [
            'key' => ['required'],
            'amount' => ['sometimes', 'decimal:2'],
            'payerCpf' => ['required_without:payerCnpj'],
            'payerCnpj' => ['required_without:payerCpf'],
            'payerQuestion' => ['sometimes'],
            'payerName' => ['sometimes', 'string'],
            'additionalInformation' => ['sometimes', 'array'],
            'additionalInformation.*.value' => ['required_with:additionalInformation.*.key', 'string'],
            'additionalInformation.*.key' => ['required_with:additionalInformation.*.value', 'string'],
            'expiration' => ['sometimes'],
        ];
    }
}
