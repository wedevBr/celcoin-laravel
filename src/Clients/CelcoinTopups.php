<?php

namespace WeDevBr\Celcoin\Clients;

use Carbon\Carbon;
use Illuminate\Http\Client\RequestException;
use Illuminate\Support\Facades\Validator;
use WeDevBr\Celcoin\Common\CelcoinBaseApi;
use WeDevBr\Celcoin\Rules\Topups\Cancel as TopupsCancel;
use WeDevBr\Celcoin\Rules\Topups\Confirm as TopupsConfirm;
use WeDevBr\Celcoin\Rules\Topups\Create as TopupsCreate;
use WeDevBr\Celcoin\Rules\Topups\Providers as TopupsProviders;
use WeDevBr\Celcoin\Rules\Topups\ProvidersValues as TopupsProvidersValues;
use WeDevBr\Celcoin\Types\Topups\Cancel;
use WeDevBr\Celcoin\Types\Topups\Confirm;
use WeDevBr\Celcoin\Types\Topups\Create;
use WeDevBr\Celcoin\Types\Topups\Providers;
use WeDevBr\Celcoin\Types\Topups\ProvidersValues;

/**
 * Class CelcoinTopups
 * A API de Recargas Nacionais disponibiliza aos seus usuários a possibilidade de realizar recargas de telefonia e conteúdos digitais listados abaixo:
 * @package WeDevBr\Celcoin
 */
class CelcoinTopups extends CelcoinBaseApi
{
    public function getProviders(Providers $data): mixed
    {
        $body = Validator::validate($data->toArray(), TopupsProviders::rules());
        return $this->get(
            "/v5/transactions/topups/providers",
            $body
        );
    }

    public function getProviderValues(ProvidersValues $data): mixed
    {
        $body = Validator::validate($data->toArray(), TopupsProvidersValues::rules());
        return $this->get(
            "/v5/transactions/topups/provider-values",
            $body
        );
    }

    public function create(Create $data): mixed
    {
        $body = Validator::validate($data->toArray(), TopupsCreate::rules());
        return $this->post(
            "/v5/transactions/topups/topups",
            $body
        );
    }

    public function confirm(int $transactionId, Confirm $data): mixed
    {
        $body = Validator::validate($data->toArray(), TopupsConfirm::rules());
        return $this->put(
            "/v5/transactions/topups/{$transactionId}/capture",
            $body
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

    public function cancel(int $transactionId, Cancel $data): mixed
    {
        $body = Validator::validate($data->toArray(), TopupsCancel::rules());
        return $this->delete(
            "/v5/transactions/topups/{$transactionId}/void",
            $body
        );
    }

    public function findProviders(?int $statusCode = null, ?int $phoneNumber = null): mixed
    {
        return $this->get(
            "/v5/transactions/topups/find-providers",
            [
                'statusCode' => $statusCode ?? null,
                'PhoneNumber' => $phoneNumber ?? null,
            ]
        );
    }
}
