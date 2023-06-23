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
    const GET_STATIC_PAYMENT_ENDPOINT = '/pix/v1/brcode/static/%d';

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

    /**
     * @param int $transactionId
     * @return array|null
     * @throws RequestException
     */
    final public function getStaticPix(int $transactionId): ?array
    {
        return $this->get(
            sprintf(self::GET_STATIC_PAYMENT_ENDPOINT, $transactionId)
        );
    }
}
