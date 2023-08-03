<?php

namespace WeDevBr\Celcoin\Rules\PIX;

class PixReactivateEventAndResendSpecifiedMessagesInList
{
    public static function rules(): array
    {
        return [
            'transactionsToResend' => ['sometimes', 'array'],
            'transactionsToResend.*' => ['sometimes', 'integer'],
        ];
    }
}
