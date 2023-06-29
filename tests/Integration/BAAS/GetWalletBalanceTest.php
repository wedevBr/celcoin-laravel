<?php

namespace Tests\Integration\BAAS;

use GuzzleHttp\Promise\PromiseInterface;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Http;
use Tests\GlobalStubs;
use Tests\TestCase;
use WeDevBr\Celcoin\Clients\CelcoinBAAS;

class GetWalletBalanceTest extends TestCase
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
                    sprintf(CelcoinBAAS::GET_WALLET_BALANCE, '1234', '25400754015')
                ) => self::stubSuccess()
            ]
        );
        $baasWebhook = new CelcoinBAAS();
        $response = $baasWebhook->getWalletBalance('1234', '25400754015');

        $this->assertEquals('SUCCESS', $response['status']);
    }

    static private function stubSuccess(): PromiseInterface
    {
        return Http::response(
            [
                "status" => "SUCCESS",
                "version" => "1.0.0",
                "body" => [
                    "amount" => 1.1
                ]
            ],
            Response::HTTP_OK
        );
    }
}
