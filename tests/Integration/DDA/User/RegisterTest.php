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
            "document" => '71929784007',
            "clientName" => "Customer Teste de Sucesso",
            "clientRequestId" => "customer_sucess_teste"
        ]));

        $this->assertEquals(201, $response['status']);
    }

    static private function stubSuccess(): PromiseInterface
    {
        return Http::response(
            [
                "status" => 201,
                "body" => [
                    "document" => "64834852393",
                    "clientRequestId" => "0001",
                    "responseDate" => "2023-07-17T20:53:09.3583614+00:00",
                    "status" => "PROCESSING",
                    "subscriptionId" => "058f3598-a2ad-464d-9bec-96a045cfde6a",
                ]
            ],
            Response::HTTP_OK
        );
    }
}
