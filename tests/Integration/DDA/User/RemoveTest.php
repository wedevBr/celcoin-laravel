<?php

namespace Tests\Integration\DDA\User;

use GuzzleHttp\Promise\PromiseInterface;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Http;
use Tests\GlobalStubs;
use Tests\TestCase;
use WeDevBr\Celcoin\Clients\CelcoinDDAUser;
use WeDevBr\Celcoin\Types\DDA\RemoveUser;

class RemoveTest extends TestCase
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
                    CelcoinDDAUser::REMOVE_ENDPOINT
                ) => self::stubSuccess()
            ]
        );

        $dda = new CelcoinDDAUser();
        $response = $dda->remove(new RemoveUser([
            "document" => "64834852393",
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
                    "responseDate" => "2023-01-18T19:54:16.6647364+00:00",
                    "status" => "PROCESSING",
                    "subscriptionId" => "37c571d7-a594-4a11-8629-2e993beecf5d"
                ]
            ],
            Response::HTTP_OK
        );
    }
}
