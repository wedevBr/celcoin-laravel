<?php

namespace WeDevBr\Celcoin\Rules\BAAS;

class RefundPix
{
    public static function rules()
    {
        return [
            'id' => ['nullable', 'string'],
            'endToEndId' => ['nullable', 'string'],
            'clientCode' => ['required', 'string'],
            'amount' => ['required', 'numeric'],
            'reason' => ['required', 'string'],
            'reversalDescription' => ['nullable', 'string'],
        ];
    }
}
