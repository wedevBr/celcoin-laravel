<?php

namespace Tests\Integration\BAAS\TED;

use GuzzleHttp\Promise\PromiseInterface;
use Illuminate\Support\Facades\Http;
use Symfony\Component\HttpFoundation\Response;
use Tests\GlobalStubs;
use Tests\TestCase;
use WeDevBr\Celcoin\Clients\CelcoinBAASTED;
use WeDevBr\Celcoin\Enums\ClientFinalityEnum;
use WeDevBr\Celcoin\Types\BAAS\TEDTransfer;

class BAASTEDTransferTest extends TestCase
{

    final public function testSuccess(): void
    {
        Http::fake(
            [
                config('celcoin.login_url') => GlobalStubs::loginResponse(),
                sprintf(
                    '%s%s',
                    config('api_url'),
                    CelcoinBAASTED::TRANSFER_ENDPOINT
                ) => self::stubSuccess()
            ]
        );

        $ted = new CelcoinBAASTED();
        $response = $ted->transfer(new TEDTransfer([
            "amount" => 4.00,
            "clientCode" => "1234",
            "debitParty" => [
                "account" => "300541976902"
            ],
            "creditParty" => [
                "bank" => "30306294",
                "account" => "300541976910",
                "branch" => "0001",
                "taxId" => "00558856756",
                "name" => "Noelí Valência",
                "accountType" => "CC",
                "personType" => "J",
            ],
            "clientFinality" => ClientFinalityEnum::ACCOUNT_CREDIT,
            "description" => "",
        ]));

        $this->assertEquals('PROCESSING', $response['status']);
    }

    static private function stubSuccess(): PromiseInterface
    {
        return Http::response(
            [
                "status" => "PROCESSING",
                "version" => "1.0.0",
                "body" => [
                    "id" => "222dbad8-c309-4f52-af62-8bfbe945ca2d",
                    "amount" => 4,
                    "clientCode" => "1234",
                    "debitParty" => [
                        "account" => "300541976902",
                        "branch" => "0001",
                        "taxId" => "17938715000192",
                        "name" => "Mateus",
                        "accountType" => "CC",
                        "personType" => "J",
                        "bank" => "13935893",
                    ],
                    "creditParty" => [
                        "bank" => "30306294",
                        "account" => "300541976910",
                        "branch" => "0001",
                        "taxId" => "00558856756",
                        "name" => "Noelí Valência",
                        "accountType" => "CC",
                        "personType" => "J",
                    ]
                ]
            ],
            Response::HTTP_OK
        );
    }
}
