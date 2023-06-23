<?php

namespace WeDevBr\Celcoin\Rules\PIX;

class QRStaticPaymentGetQR
{
    /**
     * @return array[]
     */
    public static function rules(): array
    {
        return [
            'pixelsPerModule' => ['sometimes', 'int'],
            'imageType' => ['sometimes', 'in:PNG'],
        ];
    }
}
