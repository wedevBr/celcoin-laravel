<?php

namespace WeDevBr\Celcoin\Clients;

use Illuminate\Support\Facades\Validator;
use WeDevBr\Celcoin\Common\CelcoinBaseApi;
use WeDevBr\Celcoin\Rules\KYC\CreateKycRule;
use WeDevBr\Celcoin\Types\KYC\CreateKyc;

class CelcoinKyc extends CelcoinBaseApi
{
    public const CREATE_KYC_ENDPOINT = '/v1/fileupload';

    public function createKyc(CreateKyc $data): array
    {
        $body = Validator::validate($data->toArray(), CreateKycRule::rules());

        return $this->post(
            self::CREATE_KYC_ENDPOINT,
            $body
        );
    }
}
