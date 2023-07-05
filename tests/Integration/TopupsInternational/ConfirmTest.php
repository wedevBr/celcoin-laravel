<?php

namespace Tests\Integration\TopupsInternational;

use GuzzleHttp\Promise\PromiseInterface;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Http;
use Tests\GlobalStubs;
use Tests\TestCase;
use WeDevBr\Celcoin\Clients\CelcoinInternationalTopups;
use WeDevBr\Celcoin\Types\InternationalTopups\Confirm;

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
                    sprintf(CelcoinInternationalTopups::CONFIRM_ENDPOINT, 816057734)
                ) => self::stubSuccess()
            ]
        );

        $topups = new CelcoinInternationalTopups();
        $response = $topups->confirm(816057734, new Confirm([
            "externalNSU" => 123,
            "externalTerminal" => "41233"
        ]));
        $this->assertEquals(0, $response['status']);
    }

    static private function stubSuccess(): PromiseInterface
    {
        return Http::response(
            [
                "errorCode" => "000",
                "message" => "SUCESSO",
                "status" => 0
            ],
            Response::HTTP_OK
        );
    }
}
