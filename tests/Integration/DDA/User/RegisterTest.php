<?php

namespace Tests\Integration\DDA\User;

use GuzzleHttp\Promise\PromiseInterface;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Http;
use Tests\GlobalStubs;
use Tests\TestCase;
use WeDevBr\Celcoin\Clients\CelcoinDDAUser;
use WeDevBr\Celcoin\Types\DDA\RegisterUser;

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
                    CelcoinDDAUser::REGISTER_ENDPOINT
                ) => self::stubSuccess()
            ]
        );

        $dda = new CelcoinDDAUser();
        $response = $dda->register(new RegisterUser([
            "document" => "23155663049",
            "clientName" => "Celcoin Customer",
            "clientRequestId" => "0001"
        ]));

        $this->assertEquals(201, $response['status']);
    }

    static private function stubSuccess(): PromiseInterface
    {
        return Http::response(
            [
                "status" => 201,
                "body" => [
                    "document" => "23155663049",
                    "clientRequestId" => "0001",
                    "responseDate" => "2022-11-17T14:03:06.4688394+00:00",
                    "status" => "PROCESSING",
                    "subscriptionId" => "bfacff76-de86-4b8d-9797-4ea565b4f60d"
                ]
            ],
            Response::HTTP_OK
        );
    }
}
