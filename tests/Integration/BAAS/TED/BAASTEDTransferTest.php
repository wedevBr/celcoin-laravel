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
            "amount" => 0.01,
            "clientCode" => "ad575298-8e81-4f90-a0b0-f3a04d8a48c6",
            "debitParty" => ["account" => "30023646056255"],
            "creditParty" => [
                "bank" => "30306294",
                "account" => "000001",
                "branch" => "20",
                "taxId" => "07693440704",
                "name" => "Davi Ferreira de Sousa",
                "accountType" => "CC",
                "personType" => "J",
            ],
            "clientFinality" => ClientFinalityEnum::SAME_OWNER_TRANSFER,
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
                    "id" => "34fee7bc-4d40-4605-9af8-398ed7d0d6b5",
                    "amount" => 0,
                    "clientCode" => "1458854",
                    "debitParty" => [
                        "account" => "444444",
                        "branch" => "1",
                        "taxId" => "11122233344",
                        "name" => "Celcoin",
                        "accountType" => "CACC",
                        "personType" => "F",
                        "bank" => "30306294",
                    ],
                    "creditParty" => [
                        "bank" => "30306294",
                        "account" => "10545584",
                        "branch" => "1",
                        "taxId" => "11122233344",
                        "name" => "Celcoin",
                        "accountType" => "CC",
                        "personType" => "F",
                    ],
                ],
            ],
            Response::HTTP_OK
        );
    }
}
