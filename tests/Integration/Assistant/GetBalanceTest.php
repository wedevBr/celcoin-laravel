<?php

namespace WeDevBr\Celcoin\Tests\Integration\Assistant;

use GuzzleHttp\Promise\PromiseInterface;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Http;
use WeDevBr\Celcoin\Clients\CelcoinAssistant;
use WeDevBr\Celcoin\Tests\GlobalStubs;
use WeDevBr\Celcoin\Tests\TestCase;

class GetBalanceTest extends TestCase
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
                    CelcoinAssistant::GET_BALANCE_ENDPOINT,
                ) => self::stubSuccess(),
            ],
        );

        $assistant = new CelcoinAssistant();
        $response = $assistant->getBalance();
        $this->assertEquals(0, $response['status']);
    }

    static private function stubSuccess(): PromiseInterface
    {
        return Http::response(
            [
                "anticipated" => 0,
                "reconcileExecuting" => "N",
                "consumed" => 0,
                "credit" => 0.01,
                "balance" => 999999999.01,
                "errorCode" => "000",
                "message" => "SUCESSO",
                "status" => 0,
            ],
            Response::HTTP_OK,
        );
    }
}
