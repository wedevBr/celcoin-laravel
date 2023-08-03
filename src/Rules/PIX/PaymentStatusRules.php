<?php

namespace WeDevBr\Celcoin\Rules\PIX;

class PaymentStatusRules
{
    /**
     * @return array[]
     */
    public static function rules(): array
    {
        return [
            'transactionId' => ['required_without_all:endtoendId,clientCode'],
            'endtoendId' => ['required_without_all:transactionId,clientCode'],
            'clientCode' => ['required_without_all:transactionId,endtoendId'],
        ];
    }
}
