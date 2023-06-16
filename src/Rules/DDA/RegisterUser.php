<?php

namespace WeDevBr\Celcoin\Rules\DDA;

class RegisterUser
{
    public static function rules()
    {
        return [
            "document" => ['required', 'string'],
            "clientName" => ['required', 'string'],
            "clientRequestId" => ['nullable', 'string'],
        ];
    }
}
