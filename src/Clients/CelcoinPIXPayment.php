<?php

namespace WeDevBr\Celcoin\Clients;

use Illuminate\Http\Client\RequestException;
use Illuminate\Support\Facades\Validator;
use WeDevBr\Celcoin\Common\CelcoinBaseApi;
use WeDevBr\Celcoin\Rules\PIX\EndToEndRules;
use WeDevBr\Celcoin\Types\PIX\PaymentEndToEnd;

class CelcoinPIXPayment extends CelcoinBaseApi
{
    const END_TO_END_PAYMENT_ENDPOINT = '/pix/v1/payment/endToEnd';

    /**
     * @param PaymentEndToEnd $params
     * @return array|null
     * @throws RequestException
     */
    final public function endToEndPayment(PaymentEndToEnd $params): ?array
    {
        $body = Validator::validate($params->toArray(), EndToEndRules::rules());
        return $this->post(
            self::END_TO_END_PAYMENT_ENDPOINT,
            $body
        );
    }
}
