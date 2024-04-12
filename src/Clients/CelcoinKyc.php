<?php

namespace WeDevBr\Celcoin\Clients;

use Illuminate\Http\Client\RequestException;
use Illuminate\Support\Facades\Validator;
use WeDevBr\Celcoin\Common\CelcoinBaseApi;
use WeDevBr\Celcoin\Interfaces\Attachable;
use WeDevBr\Celcoin\Rules\KYC\CreateKycRule;
use WeDevBr\Celcoin\Types\KYC\CreateKyc;

class CelcoinKyc extends CelcoinBaseApi
{
    public const CREATE_KYC_ENDPOINT = '/celcoinkyc/document/v1/fileupload';

    /**
     * @throws RequestException
     */
    public function createKyc(CreateKyc $data, ?Attachable $attachable = null): array
    {
        $body = Validator::validate($data->toArray(), CreateKycRule::rules());

        return $this->post(
            self::CREATE_KYC_ENDPOINT,
            $body,
            $attachable
        );
    }
}
