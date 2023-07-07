<?php

namespace Tests\Integration\BAAS\PixCashOut;

use GuzzleHttp\Promise\PromiseInterface;
use Illuminate\Support\Facades\Http;
use Symfony\Component\HttpFoundation\Response;
use Tests\GlobalStubs;
use Tests\TestCase;
use WeDevBr\Celcoin\Clients\CelcoinBAASPIX;

class BAASPIXStatusTest extends TestCase
{

    final public function testSuccess(): void
    {
        Http::fake(
            [
                config('celcoin.login_url') => GlobalStubs::loginResponse(),
                sprintf(
                    '%s%s*',
                    config('api_url'),
                    CelcoinBAASPIX::STATUS_PIX_ENDPOINT
                ) => self::stubSuccess()
            ]
        );

        $pix = new CelcoinBAASPIX();
        $response = $pix->statusPix(endToEndId: 'E1393589320221110144001306556986');

        $this->assertEquals('CONFIRMED', $response['status']);
    }

    static private function stubSuccess(): PromiseInterface
    {
        return Http::response(
            [
                "status" => "CONFIRMED",
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
                    "remittanceInformation" => "Texto de mensagem",
                    "error" => null
                ]
            ],
            Response::HTTP_OK
        );
    }
}
