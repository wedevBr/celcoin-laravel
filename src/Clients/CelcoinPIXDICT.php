<?php

namespace WeDevBr\Celcoin\Clients;

use Illuminate\Http\Client\RequestException;
use Illuminate\Support\Facades\Validator;
use WeDevBr\Celcoin\Common\CelcoinBaseApi;
use WeDevBr\Celcoin\Rules\PIX\DICTSearch;
use WeDevBr\Celcoin\Rules\PIX\DICTVerify;
use WeDevBr\Celcoin\Types\PIX\DICT;

class CelcoinPIXDICT extends CelcoinBaseApi
{
    public const POST_SEARCH_DICT = '/pix/v1/dict/v2/key';

    public const POST_VERIFY_DICT = '/pix/v1/dict/keychecker';

    /**
     * @throws RequestException
     */
    public function searchDICT(DICT $dict): ?array
    {
        $body = Validator::validate($dict->toArray(), DICTSearch::rules());

        return $this->post(
            self::POST_SEARCH_DICT,
            $body
        );
    }

    /**
     * @throws RequestException
     */
    public function verifyDICT(DICT $dict): ?array
    {
        $body = Validator::validate($dict->toArray(), DICTVerify::rules());

        return $this->post(
            self::POST_VERIFY_DICT,
            $body
        );
    }
}
