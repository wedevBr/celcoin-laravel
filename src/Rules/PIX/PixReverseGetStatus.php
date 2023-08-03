<?php

namespace WeDevBr\Celcoin\Rules\PIX;

class PixReverseGetStatus
{

    public static function rules(): array
    {
        return [
            'returnIdentification' => ['required_without_all:clientCode,transactionId', 'string'],
            'transactionId' => ['required_without_all:transactionId,clientCode', 'integer'],
            'clientCode' => ['required_without_all:returnIdentification,transactionId', 'string'],
        ];
    }
}
