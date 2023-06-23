<?php

namespace WeDevBr\Celcoin\Clients;

use Illuminate\Http\Client\RequestException;
use Illuminate\Support\Facades\Validator;
use WeDevBr\Celcoin\Common\CelcoinBaseApi;
use WeDevBr\Celcoin\Rules\PIX\QRStaticPaymentCreate;
use WeDevBr\Celcoin\Types\PIX\QRStaticPayment;

class CelcoinPixStaticPayment extends CelcoinBaseApi
{
    const CREATE_STATIC_PAYMENT_ENDPOINT = '/pix/v1/brcode/static';

    /**
     * @throws RequestException
     */
    final public function create(QRStaticPayment $payment): ?array
    {
        $body = Validator::validate($payment->toArray(), QRStaticPaymentCreate::rules());
        return $this->post(
            self::CREATE_STATIC_PAYMENT_ENDPOINT,
            $body
        );
    }
}
