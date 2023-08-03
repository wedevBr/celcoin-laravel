<?php

namespace WeDevBr\Celcoin\Rules\PIX;

class COBVPayload
{
    final public static function rules(): array
    {
        return [
            'url' => ['required', 'url']
        ];
    }
}
