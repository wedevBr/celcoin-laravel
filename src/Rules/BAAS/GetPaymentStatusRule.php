<?php

namespace WeDevBr\Celcoin\Rules\BAAS;

class GetPaymentStatusRule
{
    public static function rules(): array
    {
        return [
            'ClientRequestId' => ['sometimes', 'nullable', 'string'],
            'Id' => ['sometimes', 'nullable', 'string'],
        ];
    }
}
