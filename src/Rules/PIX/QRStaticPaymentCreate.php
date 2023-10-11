<?php

namespace WeDevBr\Celcoin\Rules\PIX;

use Illuminate\Validation\Rule;

class QRStaticPaymentCreate
{
    /**
     * @return array[]
     */
    public static function rules(): array
    {
        return [
            'amount' => ['required', 'decimal:2'],
            'key' => ['required', 'string'],
            'transactionIdentification' => ['required', 'string', 'regex:/[A-Za-z0-9]{1,25}/'],
            'additionalInformation' => ['sometimes', 'string'],
            'merchant' => ['required', 'array'],
            'merchant.name' => ['required', 'string', 'max:25'],
            'merchant.city' => ['required', 'string'],
            'merchant.postalCode' => ['required', 'string'],
            'merchant.merchantCategoryCode' => ['required', 'string', 'min:3', 'max:4'],
            'tags' => ['sometimes', 'array'],
            'tags.*' => ['required', 'string'],
        ];
    }
}
