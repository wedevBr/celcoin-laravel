<?php

namespace WeDevBr\Celcoin\Rules\PIX;

class PaymentEmvRules
{
    /**
     * @return array[]
     */
    public static function rules(): array
    {
        return [
            'emv' => ['required', 'string'],
        ];
    }
}
