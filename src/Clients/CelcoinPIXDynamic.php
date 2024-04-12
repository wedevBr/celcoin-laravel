<?php

namespace WeDevBr\Celcoin\Clients;

use Illuminate\Http\Client\RequestException;
use Illuminate\Support\Facades\Validator;
use WeDevBr\Celcoin\Common\CelcoinBaseApi;
use WeDevBr\Celcoin\Rules\PIX\DynamicQRCreate as DynamicQRCreateRule;
use WeDevBr\Celcoin\Rules\PIX\DynamicQRPayload as DynamicQRPayloadRule;
use WeDevBr\Celcoin\Rules\PIX\DynamicQRUpdate as DynamicQRUpdateRule;
use WeDevBr\Celcoin\Types\PIX\DynamicQRCreate;
use WeDevBr\Celcoin\Types\PIX\DynamicQRUpdate;

class CelcoinPIXDynamic extends CelcoinBaseApi
{
    public const GET_DYNAMIC_BASE64_ENDPOINT = '/pix/v1/brcode/dynamic/%d/base64';

    public const CREATE_DYNAMIC_QRCODE_ENDPOINT = '/pix/v1/brcode/dynamic';

    public const UPDATE_DYNAMIC_QRCODE_ENDPOINT = '/pix/v1/brcode/dynamic/%d';

    public const DELETE_DYNAMIC_QRCODE_ENDPOINT = '/pix/v1/brcode/dynamic/%d';

    public const PAYLOAD_DYNAMIC_QRCODE_ENDPOINT = '/pix/v1/brcode/dynamic/payload';

    /**
     * @throws RequestException
     */
    final public function getDynamicImage(int $transactionId): ?array
    {
        return $this->get(
            sprintf(self::GET_DYNAMIC_BASE64_ENDPOINT, $transactionId)
        );
    }

    /**
     * @throws RequestException
     */
    final public function createDynamicQRCode(DynamicQRCreate $data): ?array
    {
        $body = Validator::validate($data->toArray(), DynamicQRCreateRule::rules());

        return $this->post(self::CREATE_DYNAMIC_QRCODE_ENDPOINT, $body);
    }

    /**
     * @throws RequestException
     */
    final public function updateDynamicQRCode(int $transactionId, DynamicQRUpdate $data): ?array
    {
        $body = Validator::validate($data->toArray(), DynamicQRUpdateRule::rules());

        return $this->put(
            sprintf(self::UPDATE_DYNAMIC_QRCODE_ENDPOINT, $transactionId),
            $body
        );
    }

    /**
     * @throws RequestException
     */
    final public function deleteDynamicQRCode(int $transactionId): ?array
    {
        return $this->delete(
            sprintf(self::DELETE_DYNAMIC_QRCODE_ENDPOINT, $transactionId)
        );
    }

    /**
     * @throws RequestException
     */
    final public function payload(string $url): ?array
    {
        Validator::validate(compact('url'), DynamicQRPayloadRule::rules());

        return $this->post(
            sprintf(
                '%s?%s',
                self::PAYLOAD_DYNAMIC_QRCODE_ENDPOINT,
                http_build_query(compact('url'))
            )
        );
    }
}
