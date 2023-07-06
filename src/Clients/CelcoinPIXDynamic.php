<?php

namespace WeDevBr\Celcoin\Clients;

use Illuminate\Http\Client\RequestException;
use WeDevBr\Celcoin\Common\CelcoinBaseApi;

class CelcoinPIXDynamic extends CelcoinBaseApi
{
    const GET_DYNAMIC_BASE64_ENDPOINT = '/pix/v1/brcode/dynamic/%d/base64';

    /**
     * @param int $transactionId
     * @return array|null
     * @throws RequestException
     */
    final public function getDynamicImage(int $transactionId): ?array
    {
        return $this->get(
            sprintf(self::GET_DYNAMIC_BASE64_ENDPOINT, $transactionId)
        );
    }

}
