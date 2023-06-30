<?php

namespace Tests\Integration\BillPayments;

use GuzzleHttp\Promise\PromiseInterface;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Http;
use Tests\GlobalStubs;
use Tests\TestCase;
use WeDevBr\Celcoin\Clients\CelcoinBillPayment;

class StatusConsultTest extends TestCase
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
                    CelcoinBillPayment::STATUS_CONSULT_ENDPOINT
                ) => self::stubSuccess()
            ]
        );

        $payment = new CelcoinBillPayment();
        $response = $payment->statusConsult(transactionId: 9087426);
        $this->assertEquals(0, $response['transaction']['status']);
    }

    static private function stubSuccess(): PromiseInterface
    {
        return Http::response(
            [
                "transaction" => [
                    "authentication" => 6088,
                    "errorCode" => "000",
                    "createDate" => "2021-06-24T17:48:08",
                    "message" => "SUCESSO",
                    "externalNSU" => 1234,
                    "transactionId" => "7097995",
                    "status" => 0,
                    "externalTerminal" => "11122233344"
                ],
                "erroCode" => "000",
                "message" => "SUCESSO",
                "status" => "0"
            ],
            Response::HTTP_OK
        );
    }
}
