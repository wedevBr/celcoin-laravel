<?php

namespace WeDevBr\Celcoin\Clients;

use Illuminate\Http\Client\RequestException;
use Illuminate\Support\Facades\Validator;
use WeDevBr\Celcoin\Common\CelcoinBaseApi;
use WeDevBr\Celcoin\Rules\PIX\QRLocationCreate;
use WeDevBr\Celcoin\Types\PIX\QRLocation;

class CelcoinPIX extends CelcoinBaseApi
{
    const CREATE_LOCATION_ENDPOINT = '/pix/v1/location';

    /**
     * @param QRLocation $merchant
     * @return array|null
     * @throws RequestException
     */
    final public function createLocation(QRLocation $merchant): ?array
    {
        $body = Validator::validate($merchant->toArray(), QRLocationCreate::rules());
        return $this->post(
            self::CREATE_LOCATION_ENDPOINT,
            $body
        );
    }
}