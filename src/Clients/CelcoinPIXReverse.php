<?php

namespace WeDevBr\Celcoin\Clients;

use Illuminate\Http\Client\RequestException;
use Illuminate\Support\Facades\Validator;
use WeDevBr\Celcoin\Common\CelcoinBaseApi;
use WeDevBr\Celcoin\Rules\PIX as Rules;
use WeDevBr\Celcoin\Types\PIX as Types;

class CelcoinPIXReverse extends CelcoinBaseApi
{
    public const PIX_REVERSE_CREATE_ENDPOINT = '/pix/v2/reverse/pi/%s';

    public const PIX_REVERSE_GET_STATUS_ENDPOINT = '/pix/v2/reverse/pi/status';

    /**
     * @throws RequestException
     */
    final public function create(string $transactionId, Types\PixReverseCreate $reverseCreate): ?array
    {
        $params = Validator::validate($reverseCreate->toArray(), Rules\PixReverseCreate::rules());

        return $this->post(
            sprintf(self::PIX_REVERSE_CREATE_ENDPOINT, $transactionId),
            $params
        );
    }

    /**
     * @throws RequestException
     */
    final public function getStatus(Types\PixReverseGetStatus $getStatus): ?array
    {
        $params = Validator::validate($getStatus->toArray(), Rules\PixReverseGetStatus::rules());

        return $this->get(
            sprintf(
                '%s?%s',
                self::PIX_REVERSE_GET_STATUS_ENDPOINT,
                http_build_query($params)
            )
        );
    }
}
