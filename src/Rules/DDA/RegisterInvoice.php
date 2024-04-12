<?php

namespace WeDevBr\Celcoin\Rules\DDA;

class RegisterInvoice
{
    public static function rules()
    {
        return [
            'document' => ['required', 'array'],
        ];
    }
}
