<?php

namespace WeDevBr\Celcoin\Clients;

use Illuminate\Http\Client\RequestException;
use Illuminate\Support\Facades\Validator;
use WeDevBr\Celcoin\Common\CelcoinBaseApi;
use WeDevBr\Celcoin\Rules\PIX\QRStaticPaymentCreate;
use WeDevBr\Celcoin\Rules\PIX\QRStaticPaymentGetQR;
use WeDevBr\Celcoin\Types\PIX\QRStaticPayment;

class CelcoinPixStaticPayment extends CelcoinBaseApi
{
    const CREATE_STATIC_PAYMENT_ENDPOINT = '/pix/v1/brcode/static';
    const GET_STATIC_PAYMENT_ENDPOINT = '/pix/v1/brcode/static/%d';
    const GET_STATIC_PAYMENT_QR_ENDPOINT = '/pix/v1/brcode/static/%d/base64';

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

    /**
     * @param int $transactionId
     * @param array $params
     * @return array|null
     * @throws RequestException
     */
    final public function getStaticPaymentQR(int $transactionId, array $params = []): ?array
    {
        $params = Validator::validate($params, QRStaticPaymentGetQR::rules());

        $url = sprintf(self::GET_STATIC_PAYMENT_QR_ENDPOINT, $transactionId);
        return $this->get(
            sprintf('%s?%s', $url, http_build_query($params))
        );
    }
}
