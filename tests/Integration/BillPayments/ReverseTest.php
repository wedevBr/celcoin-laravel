<?php

namespace WeDevBr\Celcoin\Tests\Integration\BillPayments;

use GuzzleHttp\Promise\PromiseInterface;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Http;
use WeDevBr\Celcoin\Clients\CelcoinBillPayment;
use WeDevBr\Celcoin\Tests\GlobalStubs;
use WeDevBr\Celcoin\Tests\TestCase;

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
                    sprintf(CelcoinBillPayment::REVERSE_ENDPOINT, 817958497),
                ) => self::stubSuccess(),
            ],
        );

        $payment = new CelcoinBillPayment();
        $response = $payment->reverse(817958497);
        $this->assertEquals('0', $response['status']);
    }

    static private function stubSuccess(): PromiseInterface
    {
        return Http::response(
            [
                "errorCode" => "000",
                "message" => "Pedido de estorno registrado com sucesso.",
                "status" => "0",
            ],
            Response::HTTP_OK,
        );
    }
}
