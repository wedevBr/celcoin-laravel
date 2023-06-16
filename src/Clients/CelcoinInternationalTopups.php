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
 * @package WeDevBr\Celcoin
 */
class CelcoinInternationalTopups extends CelcoinBaseApi
{
    public function getCountries(int $page = 1, int $size = 50): mixed
    {
        return $this->get(
            "/v5/transactions/internationaltopups/countrys",
            [
                'page' => $page,
                'size' => $size,
            ]
        );
    }

    public function getValues(?string $countryCode = null, string $phoneNumber = null): mixed
    {
        return $this->get(
            "/v5/transactions/internationaltopups/values",
            [
                'countryCode' => $countryCode,
                'phoneNumber' => $phoneNumber,
            ]
        );
    }

    /**
     * @return array|mixed
     * @throws RequestException
     */
    public function create(Create $data): mixed
    {
        $body = Validator::validate($data->toArray(), InternationalTopupsCreate::rules());
        return $this->post(
            "/v5/transactions/internationaltopups",
            $body
        );
    }

    public function confirm(int $transactionId, Confirm $data): mixed
    {
        $body = Validator::validate($data->toArray(), InternationalTopupsConfirm::rules());
        return $this->put(
            "/v5/transactions/internationaltopups/{$transactionId}/capture",
            $body
        );
    }

    public function cancel(int $transactionId, Cancel $data): mixed
    {
        $body = Validator::validate($data->toArray(), InternationalTopupsCancel::rules());
        return $this->delete(
            "/v5/transactions/internationaltopups/{$transactionId}/void",
            $body
        );
    }
}
