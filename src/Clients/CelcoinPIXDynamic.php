<?php

namespace WeDevBr\Celcoin\Clients;

use Illuminate\Http\Client\RequestException;
use Illuminate\Support\Facades\Validator;
use WeDevBr\Celcoin\Common\CelcoinBaseApi;
use WeDevBr\Celcoin\Rules\PIX\DynamicQRCreate as DynamicQRCreateRule;
use WeDevBr\Celcoin\Rules\PIX\DynamicQRUpdate as DynamicQRUpdateRule;
use WeDevBr\Celcoin\Types\PIX\DynamicQRCreate;
use WeDevBr\Celcoin\Types\PIX\DynamicQRUpdate;

class CelcoinPIXDynamic extends CelcoinBaseApi
{
    const GET_DYNAMIC_BASE64_ENDPOINT = '/pix/v1/brcode/dynamic/%d/base64';
    const CREATE_DYNAMIC_QRCODE_ENDPOINT = '/pix/v1/brcode/dynamic';
    const UPDATE_DYNAMIC_QRCODE_ENDPOINT = '/pix/v1/brcode/dynamic/%d';
    const DELETE_DYNAMIC_QRCODE_ENDPOINT = '/pix/v1/brcode/dynamic/%d';

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

    /**
     * @param int $transactionId
     * @param DynamicQRUpdate $data
     * @return array|null
     * @throws RequestException
     */
    final public function updateDynamicQRCode(int $transactionId, DynamicQRUpdate $data): ?array
    {
        $body = Validator::validate($data->toArray(), DynamicQRUpdateRule::rules());
        return $this->put(
            sprintf(self::UPDATE_DYNAMIC_QRCODE_ENDPOINT, $transactionId), $body
        );
    }

    /**
     * @param int $transactionId
     * @return array|null
     * @throws RequestException
     */
    final public function deleteDynamicQRCode(int $transactionId): ?array
    {
        return $this->delete(
            sprintf(self::DELETE_DYNAMIC_QRCODE_ENDPOINT, $transactionId)
        );
    }
}
