<?php

namespace WeDevBr\Celcoin\Clients;

use Illuminate\Http\Client\RequestException;
use Illuminate\Support\Facades\Validator;
use WeDevBr\Celcoin\Common\CelcoinBaseApi;
use WeDevBr\Celcoin\Rules\PIX\DynamicQRCreate as DynamicQRCreateRule;
use WeDevBr\Celcoin\Types\PIX\DynamicQRCreate;

class CelcoinPIXDynamic extends CelcoinBaseApi
{
    const GET_DYNAMIC_BASE64_ENDPOINT = '/pix/v1/brcode/dynamic/%d/base64';
    const CREATE_DYNAMIC_QRCODE_ENDPOINT = '/pix/v1/brcode/dynamic';

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

    /**
     * @param DynamicQRCreate $data
     * @return array|null
     * @throws RequestException
     */
    final public function createDynamicQRCode(DynamicQRCreate $data): ?array
    {
        $body = Validator::validate($data->toArray(), DynamicQRCreateRule::rules());
        return $this->post(self::CREATE_DYNAMIC_QRCODE_ENDPOINT, $body);
    }
}
