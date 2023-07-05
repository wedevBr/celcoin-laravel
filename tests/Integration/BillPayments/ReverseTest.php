<?php

namespace Tests\Integration\BillPayments;

use GuzzleHttp\Promise\PromiseInterface;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Http;
use Tests\GlobalStubs;
use Tests\TestCase;
use WeDevBr\Celcoin\Clients\CelcoinBillPayment;

class ReverseTest extends TestCase
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
                    sprintf(CelcoinBillPayment::REVERSE_ENDPOINT, 2604)
                ) => self::stubSuccess()
            ]
        );

        $payment = new CelcoinBillPayment();
        $response = $payment->reverse(2604);
        $this->assertEquals('0', $response['status']);
    }

    static private function stubSuccess(): PromiseInterface
    {
        return Http::response(
            [
                "errorCode" => "000",
                "message" => "Pedido de estorno registrado com sucesso.",
                "status" => "0"
            ],
            Response::HTTP_OK
        );
    }
}