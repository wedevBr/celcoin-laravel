<?php

namespace WeDevBr\Celcoin\Rules\DDA;

class RemoveUser
{
    public static function rules()
    {
        return [
            "document" => ['required', 'string'],
            "clientRequestId" => ['nullable', 'string'],
        ];
    }
}
