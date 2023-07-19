<?php

namespace WeDevBr\Celcoin\Clients;

use Illuminate\Http\Client\RequestException;
use Illuminate\Support\Facades\Validator;
use WeDevBr\Celcoin\Common\CelcoinBaseApi;
use WeDevBr\Celcoin\Rules\PIX\PaymentEmvRules;
use WeDevBr\Celcoin\Rules\PIX\PaymentEndToEndRules;
use WeDevBr\Celcoin\Rules\PIX\PaymentInitRules;
use WeDevBr\Celcoin\Rules\PIX\PaymentStatusRules;
use WeDevBr\Celcoin\Types\PIX\PaymentEmv;
use WeDevBr\Celcoin\Types\PIX\PaymentEndToEnd;
use WeDevBr\Celcoin\Types\PIX\PaymentInit;
use WeDevBr\Celcoin\Types\PIX\PaymentStatus;

class CelcoinPIXPayment extends CelcoinBaseApi
{
    const END_TO_END_PAYMENT_ENDPOINT = '/pix/v1/payment/endToEnd';
    const EMV_PAYMENT_ENDPOINT = '/pix/v1/emv';
    const STATUS_PAYMENT_ENDPOINT = '/pix/v1/payment/pi/status';
    const INIT_PAYMENT_ENDPOINT = '/pix/v1/payment';

    /**
     * @param PaymentEndToEnd $params
     * @return array|null
     * @throws RequestException
     */
    final public function endToEndPayment(PaymentEndToEnd $params): ?array
    {
        $body = Validator::validate($params->toArray(), PaymentEndToEndRules::rules());

        dd($body);
        return $this->post(
            self::END_TO_END_PAYMENT_ENDPOINT,
            $body
        );
    }

    /**
     * @throws RequestException
     */
    final public function emvPayment(PaymentEmv $params): ?array
    {
        $body = Validator::validate($params->toArray(), PaymentEmvRules::rules());
        return $this->post(
            self::EMV_PAYMENT_ENDPOINT,
            $body
        );
    }

    /**
     * @throws RequestException
     */
    final public function statusPayment(PaymentStatus $params): ?array
    {
        $params = Validator::validate($params->toArray(), PaymentStatusRules::rules());
        return $this->get(
            sprintf(
                '%s?%s',
                self::STATUS_PAYMENT_ENDPOINT,
                http_build_query($params)
            )
        );
    }

    /**
     * @throws RequestException
     */
    final public function initPayment(PaymentInit $params): ?array
    {
        $body = Validator::validate($params->toArray(), PaymentInitRules::rules());
        return $this->post(
            self::INIT_PAYMENT_ENDPOINT,
            $body
        );
    }
}
