<?php

namespace WeDevBr\Celcoin\Rules\PIX;

class DICTVerify
{
    /**
     * @return array[]
     */
    public static function rules(): array
    {
        return [
            'keys' => ['required', 'array'],
            'keys.key' => ['required'],
        ];
    }
}