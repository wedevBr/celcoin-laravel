<?php

namespace WeDevBr\Celcoin\Tests\Integration\Assistant;

use GuzzleHttp\Promise\PromiseInterface;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Http;
use WeDevBr\Celcoin\Clients\CelcoinAssistant;
use WeDevBr\Celcoin\Tests\GlobalStubs;
use WeDevBr\Celcoin\Tests\TestCase;

class PendenciesTest extends TestCase
{
    /**
     * @return void
     */
    public function testSuccess()
    {
        Http::fake(
            [
                config('celcoin.login_url') => GlobalStubs::loginResponse(),
                sprintf(
                    '%s%s*',
                    config('api_url'),
                    CelcoinAssistant::GET_PENDENCIES_LIST_ENDPOINT,
                ) => self::stubSuccess(),
            ],
        );

        $assistant = new CelcoinAssistant();
        $response = $assistant->getPendenciesList();
        $this->assertEquals(0, $response['status']);
    }

    static private function stubSuccess(): PromiseInterface
    {
        return Http::response(
            [
                "pendings" => [
                    "transactions" => [
                        [
                            "authentication" => 3470,
                            "createDate" => "2021-06-24T11:31:10",
                            "externalNSU" => 1234,
                            "transactionId" => 7061967,
                            "status" => 4,
                            "externalTerminal" => "11122233344",
                        ],
                    ],
                ],
                "errorCode" => "000",
                "message" => "SUCESSO",
                "status" => "0",
            ],
            Response::HTTP_OK,
        );
    }
}
