<?php

namespace WeDevBr\Celcoin\Rules\PIX;

class COBGet
{
    /**
     * @return array[]
     */
    public static function rules(): array
    {
        return [
            'transactionId' => ['required_without_all:clientRequestId,transactionIdentification'],
            'clientRequestId' => ['required_without_all:transactionId,transactionIdentification'],
            'transactionIdentification' => ['required_without_all:transactionId,clientRequestId'],
        ];
    }
}
