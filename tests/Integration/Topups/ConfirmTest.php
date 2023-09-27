<?php

namespace WeDevBr\Celcoin\Tests\Integration\Topups;

use GuzzleHttp\Promise\PromiseInterface;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Http;
use WeDevBr\Celcoin\Clients\CelcoinTopups;
use WeDevBr\Celcoin\Tests\GlobalStubs;
use WeDevBr\Celcoin\Tests\TestCase;
use WeDevBr\Celcoin\Types\Topups\Confirm;

class ConfirmTest extends TestCase
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
                    sprintf(CelcoinTopups::CONFIRM_ENDPOINT, 817981234),
                ) => self::stubSuccess(),
            ],
        );

        $topups = new CelcoinTopups();
        $response = $topups->confirm(
            817981234,
            new Confirm([
                "externalNSU" => 1234,
                "externalTerminal" => "teste2",
            ]),
        );
        $this->assertEquals(0, $response['status']);
    }

    static private function stubSuccess(): PromiseInterface
    {
        return Http::response(
            [
                "errorCode" => "000",
                "message" => "SUCESSO",
                "status" => 0,
            ],
            Response::HTTP_OK,
        );
    }
}
