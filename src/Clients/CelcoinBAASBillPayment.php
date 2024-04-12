<?php

namespace WeDevBr\Celcoin\Clients;

use Illuminate\Http\Client\RequestException;
use Illuminate\Support\Facades\Validator;
use WeDevBr\Celcoin\Common\CelcoinBaseApi;
use WeDevBr\Celcoin\Rules\BAAS\BillPaymentRule;
use WeDevBr\Celcoin\Rules\BAAS\GetPaymentStatusRule;
use WeDevBr\Celcoin\Types\BAAS\BillPayment;
use WeDevBr\Celcoin\Types\BAAS\GetPaymentStatusRequest;

/**
 * Class CelcoinBAASBillPayment
 * Essa funcionalidade permite realizar pagamentos das mais diversas modalidades, incluindo contas de água, luz, gás,
 * telefone, internet, multas, tributos e boletos de contas BAAS.
 */
class CelcoinBAASBillPayment extends CelcoinBaseApi
{
    public const MAKE_PAYMENT_ENDPOINT = '/baas/v2/billpayment';

    public const GET_PAYMENT_STATUS = self::MAKE_PAYMENT_ENDPOINT.'/status';

    /**
     * @throws RequestException
     */
    public function makePayment(BillPayment $data): mixed
    {
        $body = Validator::validate($data->toArray(), BillPaymentRule::rules());

        return $this->post(
            self::MAKE_PAYMENT_ENDPOINT,
            $body
        );
    }

    /**
     * @throws RequestException
     */
    public function getPaymentStatus(GetPaymentStatusRequest $paymentStatusRequest): mixed
    {
        $query = Validator::validate($paymentStatusRequest->toArray(), GetPaymentStatusRule::rules());

        return $this->get(
            self::GET_PAYMENT_STATUS,
            $query
        );
    }
}
