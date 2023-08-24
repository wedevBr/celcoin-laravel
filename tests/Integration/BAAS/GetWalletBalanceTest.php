<?php

namespace WeDevBr\Celcoin\Tests\Integration\BAAS;

use GuzzleHttp\Promise\PromiseInterface;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Http;
use WeDevBr\Celcoin\Clients\CelcoinBAAS;
use WeDevBr\Celcoin\Tests\GlobalStubs;
use WeDevBr\Celcoin\Tests\TestCase;

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
                    sprintf(CelcoinBAAS::GET_WALLET_BALANCE, '0001', '300541976902'),
                ) => self::stubSuccess(),
            ],

        );
        $baasWebhook = new CelcoinBAAS();
        $response = $baasWebhook->getWalletBalance('300541976902');

        $this->assertEquals('SUCCESS', $response['status']);
    }

    static private function stubSuccess(): PromiseInterface
    {
        return Http::response(
            [
                "status" => "SUCCESS",
                "version" => "1.0.0",
                "body" => [
                    "amount" => 1.1,
                ],
            ],
            Response::HTTP_OK,
        );
    }
}
