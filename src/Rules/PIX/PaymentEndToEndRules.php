<?php

namespace WeDevBr\Celcoin\Rules\PIX;

class PaymentEndToEndRules
{
    /**
     * @return array[]
     */
    public static function rules(): array
    {
        return [
            'dpp' => ['required', 'date']
        ];
    }
}
