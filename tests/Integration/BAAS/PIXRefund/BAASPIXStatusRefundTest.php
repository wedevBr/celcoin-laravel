<?php

namespace Tests\Integration\BAAS\PIXRefund;

use GuzzleHttp\Promise\PromiseInterface;
use Illuminate\Support\Facades\Http;
use Symfony\Component\HttpFoundation\Response;
use Tests\TestCase;
use WeDevBr\Celcoin\Clients\CelcoinBAASPIX;

class BAASPIXStatusRefundTest extends TestCase
{

    final public function testSuccess(): void
    {
        Http::fake(
            [
                config('celcoin.login_url') => Http::response(
                    [
                        'access_token' => 'fake token',
                        'expires_in' => 2400,
                        'token_type' => 'bearer'
                    ],
                    Response::HTTP_OK
                ),
                sprintf(
                    '%s%s*',
                    config('api_url'),
                    CelcoinBAASPIX::STATUS_REFUND_PIX_ENDPOINT
                ) => self::stubSuccess()
            ]
        );

        $pix = new CelcoinBAASPIX();
        $response = $pix->statusRefundPix(returnIdentification: 'D3030629420200808185300887639654');

        $this->assertEquals('PROCESSING', $response['status']);
    }

    static private function stubSuccess(): PromiseInterface
    {
        return Http::response(
            [
                "status" => "PROCESSING",
                "version" => "1.0.0",
                "body" => [
                    "id" => "34fee7bc-4d40-4605-9af8-398ed7d0d6b4",
                    "amount" => 25.55,
                    "clientCode" => "1458854",
                    "originalPaymentId" => "34fee7bc-4d40-4605-9af8-398ed7d0d6b5",
                    "endToEndId" => "E3030629420200808185300887639654",
                    "returnIdentification" => "D3030629420200808185300887639654",
                    "reason" => "MD06",
                    "reversalDescription" => "Devolução do churrasco",
                ],
            ],
            Response::HTTP_OK
        );
    }
}
