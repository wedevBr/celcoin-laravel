<?php

namespace Tests\Integration\Assistant;

use GuzzleHttp\Promise\PromiseInterface;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Http;
use Tests\GlobalStubs;
use Tests\TestCase;
use WeDevBr\Celcoin\Clients\CelcoinAssistant;

class BanksTest extends TestCase
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
                    '%s%s',
                    config('api_url'),
                    CelcoinAssistant::GET_BANKS
                ) => self::stubSuccess()
            ]
        );

        $assistant = new CelcoinAssistant();
        $response = $assistant->getBanks();
        $this->assertEquals(0, $response['status']);
    }

    static private function stubSuccess(): PromiseInterface
    {
        return Http::response(
            [
                "banks" => [
                    [
                        "institutionCode" => 604,
                        "description" => "604 - 604 - BANCO INDUSTRIAL DO BRASIL S. A.",
                        "institutionName" => "604 - BANCO INDUSTRIAL DO BRASIL S. A."
                    ]
                ],
                "errorCode" => "000",
                "message" => "SUCESSO",
                "status" => 0
            ],
            Response::HTTP_OK
        );
    }
}
