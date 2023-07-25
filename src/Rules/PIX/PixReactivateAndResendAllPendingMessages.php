<?php

namespace WeDevBr\Celcoin\Rules\PIX;

class PixReactivateAndResendAllPendingMessages
{
    public static function rules(): array
    {
        return [
            'dateFrom' => ['date'],
            'dateTo' => ['date'],
        ];
    }
}
