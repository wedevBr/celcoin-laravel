<?php

namespace WeDevBr\Celcoin\Tests\Integration\DDA\Invoice;

use GuzzleHttp\Promise\PromiseInterface;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Http;
use WeDevBr\Celcoin\Clients\CelcoinDDAInvoice;
use WeDevBr\Celcoin\Tests\GlobalStubs;
use WeDevBr\Celcoin\Tests\TestCase;
use WeDevBr\Celcoin\Types\DDA\RegisterInvoice;

class RegisterTest extends TestCase
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
                    CelcoinDDAInvoice::REGISTER_ENDPOINT,
                ) => self::stubSuccess(),
            ],
        );

        $dda = new CelcoinDDAInvoice();
        $response = $dda->register(
            new RegisterInvoice([
                "document" => [
                    "28935923095",
                    "85429850012",
                ],
            ]),
        );

        $this->assertEquals(201, $response['status']);
    }

    static private function stubSuccess(): PromiseInterface
    {
        return Http::response(
            [
                "status" => 201,
                "body" => [
                    [
                        "document" => "28935923095",
                        "status" => "Success",
                    ],
                    [
                        "document" => "85429850012",
                        "status" => "Success",
                    ],
                ],
            ],
            Response::HTTP_OK,
        );
    }
}
