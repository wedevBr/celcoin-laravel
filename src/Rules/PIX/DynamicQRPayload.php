<?php

namespace WeDevBr\Celcoin\Rules\PIX;

class DynamicQRPayload
{
    /**
     * @return array[]
     */
    public static function rules(): array
    {
        return [
            'url' => ['required', 'url'],
        ];
    }
}
