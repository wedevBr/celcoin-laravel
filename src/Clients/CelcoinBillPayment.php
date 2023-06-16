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
use WeDevBr\Celcoin\Types\BillPayments\Confirm;
use WeDevBr\Celcoin\Types\BillPayments\Create;

/**
 * Class CelcoinBillPayment
 * Essa funcionalidade permite realizar pagamentos das mais diversas modalidades, incluindo contas de água, luz, gás, telefone, internet, multas, tributos e boletos.
 * @package WeDevBr\Celcoin
 */
class CelcoinBillPayment extends CelcoinBaseApi
{
    public function authorize(Authorize $data): mixed
    {
        $body = Validator::validate($data->toArray(), BillPaymentsAuthorize::rules());
        return $this->post(
            "/v5/transactions/billpayments/authorize",
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
            "/v5/transactions/billpayments",
            $body
        );
    }

    public function confirm(int $transactionId, Confirm $data): mixed
    {
        $body = Validator::validate($data->toArray(), BillPaymentsConfirm::rules());
        return $this->put(
            "/v5/transactions/billpayments/{$transactionId}/capture",
            $body
        );
    }

    public function cancel(int $transactionId, array $data): mixed
    {
        $body = Validator::validate($data, BillPaymentsCancel::rules());
        return $this->delete(
            "/v5/transactions/billpayments/{$transactionId}/void",
            $body
        );
    }

    public function reverse(int $transactionId): mixed
    {
        return $this->delete(
            "/v5/transactions/billpayments/{$transactionId}/reverse"
        );
    }

    public function statusConsult(
        ?int $transactionId = null,
        ?int $externalNSU = null,
        ?string $externalTerminal = null,
        ?Carbon $operationDate = null
    ): mixed {
        return $this->get(
            "/v5/transactions/status-consult",
            [
                'transactionId' => $transactionId,
                'externalNSU' => $externalNSU,
                'externalTerminal' => $externalTerminal,
                'operationDate' => !empty($operationDate) ? $operationDate->format("Y-m-d") : null,
            ]
        );
    }

    public function getOccurrences(?Carbon $dateStart = null, ?Carbon $dateEnd = null): mixed
    {
        return $this->get(
            "/v5/transactions/occurrency",
            [
                'DataInicio' => !empty($dateStart) ? $dateStart->format("Y-m-d") : null,
                'DataFim' => !empty($dateEnd) ? $dateEnd->format("Y-m-d") : null,
            ]
        );
    }
}
