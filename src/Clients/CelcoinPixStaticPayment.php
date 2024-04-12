<?php

namespace WeDevBr\Celcoin\Clients;

use Illuminate\Http\Client\RequestException;
use Illuminate\Support\Facades\Validator;
use WeDevBr\Celcoin\Common\CelcoinBaseApi;
use WeDevBr\Celcoin\Rules\PIX\QRStaticPaymentCreate;
use WeDevBr\Celcoin\Rules\PIX\QRStaticPaymentGetData;
use WeDevBr\Celcoin\Rules\PIX\QRStaticPaymentGetQR;
use WeDevBr\Celcoin\Types\PIX\QRStaticPayment;

class CelcoinPixStaticPayment extends CelcoinBaseApi
{
    public const CREATE_STATIC_PAYMENT_ENDPOINT = '/pix/v1/brcode/static';

    public const GET_STATIC_PAYMENT_ENDPOINT = '/pix/v1/brcode/static/%d';

    public const GET_STATIC_PAYMENT_QR_ENDPOINT = '/pix/v1/brcode/static/%d/base64';

    public const GET_STATIC_PAYMENT_DATA_ENDPOINT = '/pix/v1/brcode/static';

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
     * @throws RequestException
     */
    final public function getStaticPix(int $transactionId): ?array
    {
        return $this->get(
            sprintf(self::GET_STATIC_PAYMENT_ENDPOINT, $transactionId)
        );
    }

    /**
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

    /**
     * @throws RequestException
     */
    final public function getStaticPaymentData(array $params): ?array
    {
        $params = Validator::validate($params, QRStaticPaymentGetData::rules());

        return $this->get(
            sprintf(
                '%s?%s',
                self::GET_STATIC_PAYMENT_DATA_ENDPOINT,
                http_build_query($params)
            )
        );
    }
}
