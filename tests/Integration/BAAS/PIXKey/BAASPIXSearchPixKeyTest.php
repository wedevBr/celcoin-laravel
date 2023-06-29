<?php

namespace Tests\Integration\BAAS\PIXKey;

use GuzzleHttp\Promise\PromiseInterface;
use Illuminate\Support\Facades\Http;
use Symfony\Component\HttpFoundation\Response;
use Tests\GlobalStubs;
use Tests\TestCase;
use WeDevBr\Celcoin\Clients\CelcoinBAASPIX;

class BAASPIXSearchPixKeyTest extends TestCase
{

    final public function testSuccess(): void
    {
        Http::fake(
            [
                config('celcoin.login_url') => GlobalStubs::loginResponse(),
                sprintf(
                    '%s%s',
                    config('api_url'),
                    sprintf(CelcoinBAASPIX::SEARCH_PIX_KEY_ENDPOINT, '30054065518')
                ) => self::stubSuccess()
            ]
        );

        $pix = new CelcoinBAASPIX();
        $response = $pix->searchPixKey('30054065518');

        $this->assertEquals('SUCCESS', $response['status']);
    }

    static private function stubSuccess(): PromiseInterface
    {
        return Http::response(
            [
                "version" => "1.0.0",
                "status" => "SUCCESS",
                "body" => [
                    "listKeys" => [
                        [
                            "keyType" => "EMAIL",
                            "key" => "testebaas@cecloin.com.br",
                            "account" => [
                                "participant" => "30306294",
                                "branch" => "0001",
                                "account" => "10545584",
                                "accountType" => "TRAN",
                                "createDate" => "2020-11-03T06:30:00-03:00"
                            ],
                            "owner" => [
                                "type" => "NATURAL_PERSON",
                                "documentNumber" => "34335125070",
                                "name" => "Carlos Henrique da Silva"
                            ]
                        ]
                    ]
                ]
            ],
            Response::HTTP_OK
        );
    }
}
