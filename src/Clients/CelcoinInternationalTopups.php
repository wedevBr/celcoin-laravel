<?php

namespace WeDevBr\Celcoin\Clients;

use Illuminate\Http\Client\RequestException;
use Illuminate\Support\Facades\Validator;
use WeDevBr\Celcoin\Common\CelcoinBaseApi;
use WeDevBr\Celcoin\Rules\InternationalTopups\Cancel as InternationalTopupsCancel;
use WeDevBr\Celcoin\Rules\InternationalTopups\Confirm as InternationalTopupsConfirm;
use WeDevBr\Celcoin\Rules\InternationalTopups\Create as InternationalTopupsCreate;
use WeDevBr\Celcoin\Types\InternationalTopups\Cancel;
use WeDevBr\Celcoin\Types\InternationalTopups\Confirm;
use WeDevBr\Celcoin\Types\InternationalTopups\Create;

/**
 * Class CelcoinInternationalTopups
 * Essa funcionalidade é usada para disponibilizar aos seus usuários a possibilidade de realizar recargas de celulares internacionais.
 */
class CelcoinInternationalTopups extends CelcoinBaseApi
{
    public const GET_COUNTRIES_ENDPOINT = '/v5/transactions/internationaltopups/countrys';

    public const GET_VALUES_ENDPOINT = '/v5/transactions/internationaltopups/values';

    public const CREATE_ENDPOINT = '/v5/transactions/internationaltopups';

    public const CONFIRM_ENDPOINT = '/v5/transactions/internationaltopups/%d/capture';

    public const CANCEL_ENDPOINT = '/v5/transactions/internationaltopups/%d/void';

    public function getCountries(int $page = 1, int $size = 50): mixed
    {
        return $this->get(
            self::GET_COUNTRIES_ENDPOINT,
            [
                'page' => $page,
                'size' => $size,
            ]
        );
    }

    public function getValues(?string $countryCode = null, ?string $phoneNumber = null): mixed
    {
        return $this->get(
            self::GET_VALUES_ENDPOINT,
            [
                'countryCode' => $countryCode,
                'phoneNumber' => $phoneNumber,
            ]
        );
    }

    /**
     * @return array|mixed
     *
     * @throws RequestException
     */
    public function create(Create $data): mixed
    {
        $body = Validator::validate($data->toArray(), InternationalTopupsCreate::rules());

        return $this->post(
            self::CREATE_ENDPOINT,
            $body
        );
    }

    public function confirm(int $transactionId, Confirm $data): mixed
    {
        $body = Validator::validate($data->toArray(), InternationalTopupsConfirm::rules());

        return $this->put(
            sprintf(self::CONFIRM_ENDPOINT, $transactionId),
            $body
        );
    }

    public function cancel(int $transactionId, Cancel $data): mixed
    {
        $body = Validator::validate($data->toArray(), InternationalTopupsCancel::rules());

        return $this->delete(
            sprintf(self::CANCEL_ENDPOINT, $transactionId),
            $body
        );
    }
}
