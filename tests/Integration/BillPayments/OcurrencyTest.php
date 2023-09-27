<?php

namespace WeDevBr\Celcoin\Tests\Integration\BillPayments;

use Carbon\Carbon;
use GuzzleHttp\Promise\PromiseInterface;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Http;
use WeDevBr\Celcoin\Clients\CelcoinBillPayment;
use WeDevBr\Celcoin\Tests\GlobalStubs;
use WeDevBr\Celcoin\Tests\TestCase;

class OcurrencyTest extends TestCase
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
                    CelcoinBillPayment::GET_OCCURRENCES_ENDPOINT,
                ) => self::stubSuccess(),
            ],
        );

        $payment = new CelcoinBillPayment();
        $date = Carbon::createFromFormat('Y-m-d', '2023-07-13');
        $response = $payment->getOccurrences($date->clone()->subDay(7), $date);

        $this->assertArrayHasKey('occurrences', $response);
    }

    static private function stubSuccess(): PromiseInterface
    {
        return Http::response(
            [
                "occurrences" => [
                    "date" => "2021-06-24T19:03:43",
                    "createDate" => "2021-06-24T15:54:14",
                    "descriptionMotivo" => "Recusado pelo beneficiário",
                    "externalNSU" => 1234,
                    "transactionId" => 7061967,
                    "externalTerminal" => "11122233344",
                    "linhaDigitavel" => "34191090080012213037050059980008586260000065000 ",
                    "value" => "20",
                ],
            ],
            Response::HTTP_OK,
        );
    }
}
