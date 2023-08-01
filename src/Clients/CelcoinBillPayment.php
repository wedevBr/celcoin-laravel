<?php

namespace WeDevBr\Celcoin\Clients;

use Carbon\Carbon;
use Illuminate\Http\Client\RequestException;
use Illuminate\Support\Facades\Validator;
use WeDevBr\Celcoin\Common\CelcoinBaseApi;
use WeDevBr\Celcoin\Rules\BillPayments\Authorize as BillPaymentsAuthorize;
use WeDevBr\Celcoin\Rules\BillPayments\Create as BillPaymentsCreate;
use WeDevBr\Celcoin\Rules\BillPayments\Cancel as BillPaymentsCancel;
use WeDevBr\Celcoin\Rules\BillPayments\Confirm as BillPaymentsConfirm;
use WeDevBr\Celcoin\Types\BillPayments\Authorize;
use WeDevBr\Celcoin\Types\BillPayments\Cancel;
use WeDevBr\Celcoin\Types\BillPayments\Confirm;
use WeDevBr\Celcoin\Types\BillPayments\Create;

/**
 * Class CelcoinBillPayment
 * Essa funcionalidade permite realizar pagamentos das mais diversas modalidades, incluindo contas de água, luz, gás, telefone, internet, multas, tributos e boletos.
 * @package WeDevBr\Celcoin
 */
class CelcoinBillPayment extends CelcoinBaseApi
{

    const AUTHORIZE_ENDPOINT = '/v5/transactions/billpayments/authorize';
    const CREATE_ENDPOINT = '/v5/transactions/billpayments';
    const CONFIRM_ENDPOINT = '/v5/transactions/billpayments/%d/capture';
    const CANCEL_ENDPOINT = '/v5/transactions/billpayments/%d/void';
    const REVERSE_ENDPOINT = '/v5/transactions/billpayments/%d/reverse';
    const GET_OCCURRENCES_ENDPOINT = '/v5/transactions/occurrency';

    public function authorize(Authorize $data): mixed
    {
        $body = Validator::validate($data->toArray(), BillPaymentsAuthorize::rules());
        return $this->post(
            self::AUTHORIZE_ENDPOINT,
            $body
        );
    }

    /**
     * @return array|mixed
     * @throws RequestException
     */
    public function create(Create $data): mixed
    {
        $body = Validator::validate($data->toArray(), BillPaymentsCreate::rules());
        return $this->post(
            self::CREATE_ENDPOINT,
            $body
        );
    }

    public function confirm(int $transactionId, Confirm $data): mixed
    {
        $body = Validator::validate($data->toArray(), BillPaymentsConfirm::rules());
        return $this->put(
            sprintf(self::CONFIRM_ENDPOINT, $transactionId),
            $body
        );
    }

    public function cancel(int $transactionId, Cancel $data): mixed
    {
        $body = Validator::validate($data->toArray(), BillPaymentsCancel::rules());
        return $this->delete(
            sprintf(self::CANCEL_ENDPOINT, $transactionId),
            $body
        );
    }

    public function reverse(int $transactionId): mixed
    {
        return $this->delete(
            sprintf(self::REVERSE_ENDPOINT, $transactionId),
        );
    }

    public function getOccurrences(?Carbon $dateStart = null, ?Carbon $dateEnd = null): mixed
    {
        return $this->get(
            self::GET_OCCURRENCES_ENDPOINT,
            [
                'DataInicio' => !empty($dateStart) ? $dateStart->format("Y-m-d") : null,
                'DataFim' => !empty($dateEnd) ? $dateEnd->format("Y-m-d") : null,
            ]
        );
    }
}
