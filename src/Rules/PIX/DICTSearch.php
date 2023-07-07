<?php

namespace WeDevBr\Celcoin\Rules\PIX;

class DICTSearch
{
    /**
     * @return array[]
     */
    public static function rules(): array
    {
        return [
            'payerId' => ['required'],
            'key' => ['required'],
        ];
    }
}