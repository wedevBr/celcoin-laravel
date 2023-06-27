<?php

namespace WeDevBr\Celcoin\Clients;

use Illuminate\Http\Client\RequestException;
use Illuminate\Support\Facades\Validator;
use WeDevBr\Celcoin\Common\CelcoinBaseApi;
use WeDevBr\Celcoin\Rules\PIX\COBCreate;
use WeDevBr\Celcoin\Types\PIX\COB;

class CelcoinPIXCOB extends CelcoinBaseApi
{
    const CREATE_COB_PIX_URL = '/pix/v1/collection/immediate';

    /**
     * @throws RequestException
     */
    final public function createCOBPIX(COB $cob): array
    {
        $body = Validator::validate($cob->toArray(), COBCreate::rules());
        return $this->post(
            self::CREATE_COB_PIX_URL,
            $body
        );
    }
}
