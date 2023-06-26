<?php

namespace Tests\Integration\BAAS\PIXKey;

use GuzzleHttp\Promise\PromiseInterface;
use Illuminate\Support\Facades\Http;
use Symfony\Component\HttpFoundation\Response;
use Tests\TestCase;
use WeDevBr\Celcoin\Clients\CelcoinBAASPIX;
use WeDevBr\Celcoin\Types\BAAS\RegisterPixKey;

class BAASPIXRegisterPixKeyTest extends TestCase
{

    final public function testSuccess(): void
    {
        Http::fake(
            [
                config('celcoin.login_url') => Http::response(
                    [
                        'access_token' => 'fake token',
                        'expires_in' => 2400,
                        'token_type' => 'bearer'
                    ],
                    Response::HTTP_OK
                ),
                sprintf(
                    '%s%s',
                    config('api_url'),
                    CelcoinBAASPIX::REGISTER_PIX_KEY_ENDPOINT
                ) => self::stubSuccess()
            ]
        );

        $pix = new CelcoinBAASPIX();
        $response = $pix->registerPixKey(new RegisterPixKey([
            'account' => '444444',
            'keyType' => 'EVP',
            'key' => '',
        ]));

        $this->assertEquals('CONFIRMED', $response['status']);
    }

    static private function stubSuccess(): PromiseInterface
    {
        return Http::response(
            [
                "version" => "1.0.0",
                "status" => "CONFIRMED",
                "body" => [
                    "keyType" => "EMAIL",
                    "key" => "testebaas@cecloin.com.br",
                    "account" => [
                        "participant" => "30306294",
                        "branch" => "0001",
                        "account" => "10545584",
                        "accountType" => "TRAN",
                        "createDate" => "2020-11-03T06:30:00-03:00",
                    ],
                    "owner" => [
                        "type" => "NATURAL_PERSON",
                        "documentNumber" => "34335125070",
                        "name" => "Carlos Henrique da Silva",
                    ],
                ],
            ],
            Response::HTTP_OK
        );
    }
}
