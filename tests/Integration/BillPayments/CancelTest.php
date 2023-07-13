<?php

namespace Tests\Integration\BillPayments;

use GuzzleHttp\Promise\PromiseInterface;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Http;
use Tests\GlobalStubs;
use Tests\TestCase;
use WeDevBr\Celcoin\Clients\CelcoinBillPayment;
use WeDevBr\Celcoin\Types\BillPayments\Cancel;

class CancelTest extends TestCase
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
                    sprintf(CelcoinBillPayment::CANCEL_ENDPOINT, 817958450)
                ) => self::stubSuccess()
            ]
        );

        $payment = new CelcoinBillPayment();
        $response = $payment->cancel(817958450, new Cancel([
            "externalNSU" => 1234,
            "externalTerminal" => "teste2"
        ]));
        $this->assertEquals(0, $response['status']);
    }

    static private function stubSuccess(): PromiseInterface
    {
        return Http::response(
            [
                "errorCode" => "000",
                "message" => "SUCESSO",
                "status" => 0
            ],
            Response::HTTP_OK
        );
    }
}
