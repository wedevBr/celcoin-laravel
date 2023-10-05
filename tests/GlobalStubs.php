<?php

namespace WeDevBr\Celcoin\Tests;

use GuzzleHttp\Promise\PromiseInterface;
use Illuminate\Support\Facades\Http;
use Symfony\Component\HttpFoundation\Response;

class GlobalStubs
{
    /**
     * @return PromiseInterface
     */
    final static public function loginResponse(): PromiseInterface
    {
        return Http::response(
            [
                'access_token' => 'fake token',
                'expires_in' => 2400,
                'token_type' => 'bearer',
            ],
            Response::HTTP_OK,
        );
    }
}
