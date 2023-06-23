<?php

namespace WeDevBr\Celcoin\Rules\PIX;

class QRStaticPaymentCreate
{
    /**
     * @return array[]
     */
    public static function rules(): array
    {
        return [
            'amount' => ['required', 'regex:/\d{1,10}\.\d{2}/'],
            'key' => ['required', 'string'],
            'transactionIdentification' => ['required', 'string'],
            'additionalInformation' => ['sometimes', 'string'],
            'merchant' => ['required', 'array'],
            'merchant.name' => ['required', 'string'],
            'merchant.city' => ['required', 'string'],
            'merchant.postalCode' => ['required', 'string'],
            'merchant.merchantCategoryCode' => ['required', 'string', 'min:3', 'max:4'],
            'tags' => ['sometimes', 'array'],
            'tags.*' => ['required', 'string'],
        ];
    }
}
