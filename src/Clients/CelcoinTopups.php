<?php

namespace WeDevBr\Celcoin\Clients;

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
    const GET_PROVIDERS_ENDPOINT = '/v5/transactions/topups/providers';
    const GET_PROVIDER_VALUES_ENDPOINT = '/v5/transactions/topups/provider-values';
    const CREATE_ENDPOINT = '/v5/transactions/topups/topups';
    const CONFIRM_ENDPOINT = '/v5/transactions/topups/%d/capture';
    const CANCEL_ENDPOINT = '/v5/transactions/topups/%d/void';
    const FIND_PROVIDERS_ENDPOINT = '/v5/transactions/topups/find-providers';

    public function getProviders(Providers $data): mixed
    {
        $body = Validator::validate($data->toArray(), TopupsProviders::rules());
        return $this->get(
            self::GET_PROVIDERS_ENDPOINT,
            $body
        );
    }

    public function getProviderValues(ProvidersValues $data): mixed
    {
        $body = Validator::validate($data->toArray(), TopupsProvidersValues::rules());
        return $this->get(
            self::GET_PROVIDER_VALUES_ENDPOINT,
            $body
        );
    }

    public function create(Create $data): mixed
    {
        $body = Validator::validate($data->toArray(), TopupsCreate::rules());
        return $this->post(
            self::CREATE_ENDPOINT,
            $body
        );
    }

    public function confirm(int $transactionId, Confirm $data): mixed
    {
        $body = Validator::validate($data->toArray(), TopupsConfirm::rules());
        return $this->put(
            sprintf(self::CONFIRM_ENDPOINT, $transactionId),
            $body
        );
    }

    public function cancel(int $transactionId, Cancel $data): mixed
    {
        $body = Validator::validate($data->toArray(), TopupsCancel::rules());
        return $this->delete(
            sprintf(self::CANCEL_ENDPOINT, $transactionId),
            $body
        );
    }

    public function findProviders(int $statusCode, int $phoneNumber): mixed
    {
        return $this->get(
            self::FIND_PROVIDERS_ENDPOINT,
            [
                'statusCode' => $statusCode,
                'PhoneNumber' => $phoneNumber,
            ]
        );
    }
}
