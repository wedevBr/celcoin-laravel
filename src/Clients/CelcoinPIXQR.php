<?php

namespace WeDevBr\Celcoin\Clients;

use Illuminate\Http\Client\RequestException;
use Illuminate\Support\Facades\Validator;
use WeDevBr\Celcoin\Common\CelcoinBaseApi;
use WeDevBr\Celcoin\Rules\PIX\QRLocationCreate;
use WeDevBr\Celcoin\Types\PIX\QRLocation;

class CelcoinPIXQR extends CelcoinBaseApi
{
    public const CREATE_LOCATION_ENDPOINT = '/pix/v1/location';

    public const GET_LOCATION_ENDPOINT = '/pix/v1/location/%d';

    public const GET_QR_LOCATION_ENDPOINT = '/pix/v1/location/%d/base64';

    /**
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

    /**
     * @throws RequestException
     */
    final public function getLocation(int $locationId): ?array
    {
        return $this->get(
            sprintf(self::GET_LOCATION_ENDPOINT, $locationId)
        );
    }

    /**
     * @throws RequestException
     */
    final public function getQR(int $locationId): ?array
    {
        return $this->get(
            sprintf(self::GET_QR_LOCATION_ENDPOINT, $locationId)
        );
    }
}
