<?php

namespace WeDevBr\Celcoin\Rules\PIX;

class PixReceivementStatusGet
{
    /**
     * @return array[]
     */
    public static function rules(): array
    {
        return [
            'endtoEndId' => ['required_without_all:transactionId,transactionIdBrCode', 'string'],
            'transactionId' => ['required_without_all:endtoEndId,transactionIdBrCode', 'integer'],
            'transactionIdBrCode' => ['required_without_all:endtoEndId,transactionId', 'integer'],
        ];
    }
}
