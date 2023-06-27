<?php

namespace WeDevBr\Celcoin\Rules\PIX;

class QRStaticPaymentGetData
{
    /**
     * @return array[]
     */
    public static function rules(): array
    {
        return [
            'transactionIdBrcode' => ['int', 'required_without:transactionIdentification'],
            'transactionIdentification' => ['string', 'required_without:transactionIdBrcode'],
        ];
    }
}
