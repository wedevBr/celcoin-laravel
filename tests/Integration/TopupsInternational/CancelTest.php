<?php

namespace WeDevBr\Celcoin\Tests\Integration\TopupsInternational;

use GuzzleHttp\Promise\PromiseInterface;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Http;
use WeDevBr\Celcoin\Clients\CelcoinInternationalTopups;
use WeDevBr\Celcoin\Tests\GlobalStubs;
use WeDevBr\Celcoin\Tests\TestCase;
use WeDevBr\Celcoin\Types\InternationalTopups\Cancel;

class CancelTest extends TestCase
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
                    sprintf(CelcoinInternationalTopups::CANCEL_ENDPOINT, 817981439),
                ) => self::stubSuccess(),
            ],
        );

        $topups = new CelcoinInternationalTopups();
        $response = $topups->cancel(
            817981439,
            new Cancel([
                'externalNSU' => 1234,
                'externalTerminal' => '1123123123',
            ]),
        );
        $this->assertEquals(0, $response['status']);
    }

    private static function stubSuccess(): PromiseInterface
    {
        return Http::response(
            [
                'errorCode' => '000',
                'message' => 'SUCESSO',
                'status' => 0,
            ],
            Response::HTTP_OK,
        );
    }
}
