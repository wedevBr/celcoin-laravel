<?php

namespace WeDevBr\Celcoin\Rules\PIX;

class PixReverseCreate
{
    public static function rules(): array
    {
        return [
            'clientCode' => ['required'],
            'amount' => ['required', 'decimal:2,2'],
            'reason' => ['required', 'string', 'in:BE08,FR01,MD06,SL02'],
            'additionalInformation' => ['sometimes', 'string', 'max:105'],
            'reversalDescription' => ['sometimes', 'string', 'max:140'],
        ];
    }
}
