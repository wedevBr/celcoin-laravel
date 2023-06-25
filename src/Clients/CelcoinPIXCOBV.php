<?php

namespace WeDevBr\Celcoin\Clients;

use Illuminate\Http\Client\RequestException;
use Illuminate\Support\Facades\Validator;
use WeDevBr\Celcoin\Common\CelcoinBaseApi;
use WeDevBr\Celcoin\Rules\PIX\COBVCreate;
use WeDevBr\Celcoin\Types\PIX\COBV;

class CelcoinPIXCOBV extends CelcoinBaseApi
{
    const CREATE_COBV_PIX = '/pix/v1/collection/duedate';

    /**
     * @throws RequestException
     */
    public function createCOBVPIX(COBV $cobv)
    {
        $body = Validator::validate($cobv->toArray(), COBVCreate::rules());
        return $this->post(
            self::CREATE_COBV_PIX,
            $body
        );
    }
}