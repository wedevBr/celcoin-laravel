<?php

namespace WeDevBr\Celcoin\Clients;

use Illuminate\Http\Client\RequestException;
use Illuminate\Support\Facades\Validator;
use WeDevBr\Celcoin\Common\CelcoinBaseApi;
use WeDevBr\Celcoin\Rules\PIX\COBCreate;
use WeDevBr\Celcoin\Rules\PIX\COBGet;
use WeDevBr\Celcoin\Rules\PIX\COBUpdate;
use WeDevBr\Celcoin\Types\PIX\COB;
use WeDevBr\Celcoin\Types\PIX\COBGet as COBGetInput;

class CelcoinPIXCOB extends CelcoinBaseApi
{
    const CREATE_COB_PIX_URL = '/pix/v1/collection/immediate';
    const UPDATE_COB_PIX_URL = '/pix/v1/collection/immediate/%d';
    const GET_COB_PIX_URL = '/pix/v1/collection/pi/immediate';

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

    /**
     * @throws RequestException
     */
    final public function updateCOBPIX(int $transactionId, COB $cob): array
    {
        $body = Validator::validate($cob->toArray(), COBUpdate::rules());
        return $this->put(
            sprintf(self::UPDATE_COB_PIX_URL, $transactionId),
            $body
        );
    }

    /**
     * @throws RequestException
     */
    final public function getCOBPIX(COBGetInput $data): array
    {
        $body = Validator::validate($data->toArray(), COBGet::rules());
        return $this->get(
            self::GET_COB_PIX_URL,
            $body
        );
    }
}
