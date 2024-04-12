<?php

namespace WeDevBr\Celcoin\Rules\PIX;

class WebhookGetList
{
    public static function rules(): array
    {
        return [
            'dateFrom' => ['date'],
            'dateTo' => ['date'],
            'limit' => ['integer'],
            'start' => ['integer'],
            'onlyPending' => ['boolean'],
        ];
    }
}
