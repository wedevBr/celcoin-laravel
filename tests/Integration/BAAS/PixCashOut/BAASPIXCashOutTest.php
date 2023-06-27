<?php

namespace Tests\Integration\BAAS\PixCashOut;

use GuzzleHttp\Promise\PromiseInterface;
use Illuminate\Support\Facades\Http;
use Symfony\Component\HttpFoundation\Response;
use Tests\GlobalStubs;
use Tests\TestCase;
use WeDevBr\Celcoin\Clients\CelcoinBAASPIX;
use WeDevBr\Celcoin\Types\BAAS\PixCashOut;

class BAASPIXCashOutTest extends TestCase
{

    final public function testSuccess(): void
    {
        Http::fake(
            [
                config('celcoin.login_url') => GlobalStubs::loginResponse(),
                sprintf(
                    '%s%s',
                    config('api_url'),
                    CelcoinBAASPIX::CASH_OUT_ENDPOINT
                ) => self::stubSuccess()
            ]
        );

        $pix = new CelcoinBAASPIX();
        $response = $pix->cashOut(new PixCashOut([
            "amount" => 25.55,
            "clientCode" => "1458854",
            "transactionIdentification" => "dc8cf02b81b54bd59323453b207e704a",
            "endToEndId" => "E3030629420200808185300887639654",
            "initiationType" => "MANUAL",
            "paymentType" => "IMMEDIATE",
            "urgency" => "HIGH",
            "transactionType" => "TRANSFER",
            "debitParty" => [
                "account" => "444444"
            ],
            "creditParty" => [
                "bank" => "30306294",
                "key" => "5244f4e-15ff-413d-808d-7837652ebdc2",
                "account" => "10545584",
                "branch" => "10545584",
                "taxId" => "11122233344",
                "name" => "Celcoin",
                "accountType" => "CACC"
            ],
            "remittanceInformation" => "Texto de mensagem"
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
                    "id" => "60ec4471-71dd-43a3-a848-efe7a314d76f",
                    "amount" => 50,
                    "clientCode" => "1458856889",
                    "transactionIdentification" => null,
                    "endToEndId" => "E1393589320221110144001306556986",
                    "initiationType" => "MANUAL",
                    "paymentType" => "IMMEDIATE",
                    "urgency" => "HIGH",
                    "transactionType" => "TRANSFER",
                    "debitParty" => [
                        "account" => "30053913714179",
                        "branch" => "0001",
                        "taxId" => "77859635097",
                        "name" => "Hernani  Conrado",
                        "accountType" => "TRAN"
                    ],
                    "creditParty" => [
                        "bank" => "30306294",
                        "key" => null,
                        "account" => "42161",
                        "branch" => "20",
                        "taxId" => "12312312300",
                        "name" => "Fulano de Tal",
                        "accountType" => "CACC"
                    ],
                    "remittanceInformation" => "Texto de mensagem"
                ]
            ],
            Response::HTTP_OK
        );
    }
}
