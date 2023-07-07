<?php

namespace Tests\Integration\BAAS\PixCashOut;

use GuzzleHttp\Promise\PromiseInterface;
use Illuminate\Support\Facades\Http;
use Symfony\Component\HttpFoundation\Response;
use Tests\GlobalStubs;
use Tests\TestCase;
use WeDevBr\Celcoin\Clients\CelcoinBAASPIX;

class BAASPIXGetExternalPixKeyTest extends TestCase
{

    final public function testSuccess(): void
    {
        Http::fake(
            [
                config('celcoin.login_url') => GlobalStubs::loginResponse(),
                sprintf(
                    '%s%s*',
                    config('api_url'),
                    sprintf(CelcoinBAASPIX::GET_EXTERNAL_KEY_ENDPOINT, '')
                ) => self::stubSuccess()
            ]
        );

        $pix = new CelcoinBAASPIX();
        $response = $pix->getExternalPixKey('00611833', 'fulano@gmail.com');

        $this->assertEquals('SUCCESS', $response['status']);
    }

    static private function stubSuccess(): PromiseInterface
    {
        return Http::response(
            [
                "status" => "SUCCESS",
                "body" => [
                    "keyType" => "EMAIL",
                    "key" => "fulano@gmail.com",
                    "account" => [
                        "participant" => "60701190",
                        "branch" => "1500",
                        "account" => "00611833",
                        "accountType" => "CACC",
                        "createDate" => "2014-01-22T03:00:00.0000000Z"
                    ],
                    "owner" => [
                        "type" => "LEGAL_PERSON",
                        "documentNumber" => "05216208000166",
                        "name" => "TESTE DE RAZAO SOCIAL"
                    ],
                    "endtoEndId" => "E1393589320230324175302012347269",
                    "statistics" => [
                        "lastUpdated" => "2023-03-24T13:18:21.217Z",
                        "counters" => [
                            [
                                "type" => "SETTLEMENTS",
                                "by" => "KEY",
                                "d3" => "0",
                                "d30" => "0",
                                "m6" => "0"
                            ],
                            [
                                "type" => "SETTLEMENTS",
                                "by" => "OWNER",
                                "d3" => "0",
                                "d30" => "0",
                                "m6" => "0"
                            ],
                            [
                                "type" => "SETTLEMENTS",
                                "by" => "ACCOUNT",
                                "d3" => "0",
                                "d30" => "0",
                                "m6" => "0"
                            ],
                            [
                                "type" => "REPORTED_FRAUDS",
                                "by" => "KEY",
                                "d3" => "0",
                                "d30" => "0",
                                "m6" => "0"
                            ],
                            [
                                "type" => "REPORTED_FRAUDS",
                                "by" => "OWNER",
                                "d3" => "0",
                                "d30" => "0",
                                "m6" => "0"
                            ],
                            [
                                "type" => "REPORTED_FRAUDS",
                                "by" => "ACCOUNT",
                                "d3" => "0",
                                "d30" => "0",
                                "m6" => "0"
                            ],
                            [
                                "type" => "CONFIRMED_FRAUDS",
                                "by" => "KEY",
                                "d3" => "0",
                                "d30" => "0",
                                "m6" => "0"
                            ],
                            [
                                "type" => "CONFIRMED_FRAUDS",
                                "by" => "OWNER",
                                "d3" => "0",
                                "d30" => "0",
                                "m6" => "0"
                            ],
                            [
                                "type" => "CONFIRMED_FRAUDS",
                                "by" => "ACCOUNT",
                                "d3" => "0",
                                "d30" => "0",
                                "m6" => "0"
                            ],
                            [
                                "type" => "REJECTED",
                                "by" => "KEY",
                                "d3" => "0",
                                "d30" => "0",
                                "m6" => "0"
                            ],
                            [
                                "type" => "REJECTED",
                                "by" => "OWNER",
                                "d3" => "0",
                                "d30" => "0",
                                "m6" => "0"
                            ],
                            [
                                "type" => "REJECTED",
                                "by" => "ACCOUNT",
                                "d3" => "0",
                                "d30" => "0",
                                "m6" => "0"
                            ]
                        ]
                    ]
                ],
                "version" => "1.0.0"
            ],
            Response::HTTP_OK
        );
    }
}
