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
        $response = $pix->statusPix(endToEndId: 'E1393589320230719213601039975372');

        $this->assertEquals('CONFIRMED', $response['status']);
    }

    static private function stubSuccess(): PromiseInterface
    {
        return Http::response(
            [
                "status" => "CONFIRMED",
                "version" => "1.0.0",
                "body" =>  [
                    "id" => "fba1b37b-c0f3-440b-bcde-8228f31fd585",
                    "amount" => 5.55,
                    "clientCode" => "1234",
                    "endToEndId" => "E1393589320230719213601039975372",
                    "initiationType" => "DICT",
                    "paymentType" => "IMMEDIATE",
                    "urgency" => "HIGH",
                    "transactionType" => "TRANSFER",
                    "debitParty" => [
                        "account" => "300541976902",
                        "branch" => "0001",
                        "taxId" => "17938715000192",
                        "name" => "Mateus Chaves LTDA",
                        "accountType" => "TRAN",
                    ],
                    "creditParty" => [
                        "bank" => "30306294",
                        "key" => "845c16bf-1b02-4396-9112-623f3f7ab5f7",
                        "account" => "300541976910",
                        "branch" => "0001",
                        "taxId" => "00558856756",
                        "name" => "Noelí Valência",
                        "accountType" => "TRAN",
                    ],
                    "remittanceInformation" => "Texto de mensagem",
                ]
            ],
            Response::HTTP_OK
        );
    }
}
