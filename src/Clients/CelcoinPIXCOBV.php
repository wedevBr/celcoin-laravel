<?php

namespace WeDevBr\Celcoin\Clients;

use Illuminate\Http\Client\RequestException;
use Illuminate\Support\Facades\Validator;
use WeDevBr\Celcoin\Common\CelcoinBaseApi;
use WeDevBr\Celcoin\Rules\PIX\COBVCreate;
use WeDevBr\Celcoin\Rules\PIX\COBVGet;
use WeDevBr\Celcoin\Types\PIX\COBV;

class CelcoinPIXCOBV extends CelcoinBaseApi
{
    const CREATE_COBV_PIX = '/pix/v1/collection/duedate';
    const GET_COBV_PIX = '/pix/v1/collection/duedate';

    /**
     * @throws RequestException
     */
    final public function createCOBVPIX(COBV $cobv): ?array
    {
        $body = Validator::validate($cobv->toArray(), COBVCreate::rules());
        return $this->post(
            self::CREATE_COBV_PIX,
            $body
        );
    }

    /**
     * @throws RequestException
     */
    final public function getCOBVPIX(array $data): ?array
    {
        $params = Validator::validate($data, COBVGet::rules());
        return $this->get(
            sprintf(
                '%s?%s',
                self::GET_COBV_PIX,
                http_build_query($params)
            ),
        );
    }
}
