<?php

namespace WeDevBr\Celcoin\Rules\PIX;

class QRLocationCreate
{
    /**
     * @return array[]
     */
    public static function rules(): array
    {
        return [
            'clientRequestId' => ['required', 'string'],
            'type' => ['required', 'in:COBV,COB'],
            'merchant' => ['required', 'array'],
            'merchant.name' => ['required', 'string'],
            'merchant.city' => ['required', 'string'],
            'merchant.postalCode' => ['required', 'string'],
            'merchant.merchantCategoryCode' => ['required', 'string', 'min:3', 'max:4'],
        ];
    }
}
