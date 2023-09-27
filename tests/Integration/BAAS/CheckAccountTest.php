<?php

namespace WeDevBr\Celcoin\Tests\Integration\BAAS;

use GuzzleHttp\Promise\PromiseInterface;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Http;
use WeDevBr\Celcoin\Clients\CelcoinBAAS;
use WeDevBr\Celcoin\Tests\GlobalStubs;
use WeDevBr\Celcoin\Tests\TestCase;

class CheckAccountTest extends TestCase
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
                    '%s%s*',
                    config('api_url'),
                    CelcoinBAAS::ACCOUNT_CHECK,
                ) => self::stubSuccess(),
            ],
        );

        $baas = new CelcoinBAAS();

        $response = $baas->accountCheck('75f6941c-8e5a-4ebc-9dbf-85f528aa1628');

        $this->assertEquals('CONFIRMED', $response['status']);
    }

    static private function stubSuccess(): PromiseInterface
    {
        return Http::response(
            [
                "version" => "1.0.0",
                "status" => "CONFIRMED",
                "body" => [
                    "onboardingId" => "39c8e322-9192-498d-947e-2daa4dfc749e",
                    "clientCode" => "123456",
                    "createDate" => "2022-12-31T00:00:00.0000000+00:00",
                    "entity" => "account-create",
                    "account" => [
                        "branch" => "1234",
                        "account" => "123456",
                        "name" => "Fernanda Aparecida da Silva",
                        "documentNumber" => "47855748778",
                    ],
                ],
            ],
            Response::HTTP_OK,
        );
    }
}
