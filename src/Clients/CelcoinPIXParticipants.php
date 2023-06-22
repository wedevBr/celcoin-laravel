<?php

namespace WeDevBr\Celcoin\Clients;

use Illuminate\Http\Client\RequestException;
use WeDevBr\Celcoin\Common\CelcoinBaseApi;

class CelcoinPIXParticipants extends CelcoinBaseApi
{
    const GET_PARTICIPANTS_ENDPOINT = '/pix/v1/participants';

    /**
     * @return array|null
     * @throws RequestException
     */
    final public function getParticipants(): ?array
    {
        return $this->get(
            self::GET_PARTICIPANTS_ENDPOINT
        );
    }
}
