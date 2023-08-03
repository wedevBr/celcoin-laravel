<?php

namespace WeDevBr\Celcoin\Clients;

use Illuminate\Http\Client\RequestException;
use Illuminate\Support\Facades\Validator;
use WeDevBr\Celcoin\Common\CelcoinBaseApi;
use WeDevBr\Celcoin\Rules\PIX\PixReceivementStatusGet;
use WeDevBr\Celcoin\Types\PIX\PixReceivementStatus;

class CelcoinPIXReceivement extends CelcoinBaseApi
{
    const PIX_RECEIVEMENT_STATUS_ENDPOINT = '/pix/v1/receivement/status';

    /**
     * @throws RequestException
     */
    final public function getStatus(PixReceivementStatus $pixReceivementStatus): ?array
    {
        $params = Validator::validate($pixReceivementStatus->toArray(), PixReceivementStatusGet::rules());
        return $this->get(
            sprintf('%s?%s',
                self::PIX_RECEIVEMENT_STATUS_ENDPOINT,
                http_build_query($params)
            )
        );
    }
}
