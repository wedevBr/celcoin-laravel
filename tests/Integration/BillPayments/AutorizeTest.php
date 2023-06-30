<?php

namespace Tests\Integration\BillPayments;

use GuzzleHttp\Promise\PromiseInterface;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Http;
use Tests\GlobalStubs;
use Tests\TestCase;
use WeDevBr\Celcoin\Clients\CelcoinBillPayment;
use WeDevBr\Celcoin\Types\BillPayments\Authorize;

class AutorizeTest extends TestCase
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
                    CelcoinBillPayment::AUTHORIZE_ENDPOINT
                ) => self::stubSuccess()
            ]
        );

        $payment = new CelcoinBillPayment();
        $response = $payment->authorize(new Authorize([
            "externalTerminal" => "teste2",
            "externalNSU" => 1234,
            "barCode" => [
                "type" => 2,
                "digitable" => "03399853012970000135607559001016189020000020271",
                "barCode" => ""
            ]
        ]));
        $this->assertArrayHasKey('registerData', $response);
    }

    static private function stubSuccess(): PromiseInterface
    {
        return Http::response(
            [
                "assignor" => "BANCO SANTANDER S.A",
                "registerData" => [
                    "documentRecipient" => "21.568.259/0001-00",
                    "documentPayer" => "96.906.497/0001-00",
                    "payDueDate" => "2022-03-22T00:00:00",
                    "nextBusinessDay" => null,
                    "dueDateRegister" => "2022-02-20T00:00:00",
                    "allowChangeValue" => false,
                    "recipient" => "BENEFICIARIO AMBIENTE HOMOLOGACAO",
                    "payer" => "PAGADOR AMBIENTE HOMOLOGACAO",
                    "discountValue" => 0,
                    "interestValueCalculated" => 0,
                    "maxValue" => 202.71,
                    "minValue" => 202.71,
                    "fineValueCalculated" => 0,
                    "originalValue" => 202.71,
                    "totalUpdated" => 202.71,
                    "totalWithDiscount" => 0,
                    "totalWithAdditional" => 0
                ],
                "settleDate" => "15/02/2022",
                "dueDate" => "2022-02-20T00:00:00Z",
                "endHour" => "20:00",
                "initeHour" => "07:00",
                "nextSettle" => "N",
                "digitable" => "03399853012970000135607559001016189020000020271",
                "transactionId" => 9087400,
                "type" => 2,
                "value" => 202.71,
                "maxValue" => null,
                "minValue" => null,
                "errorCode" => "000",
                "message" => null,
                "status" => 0
            ],
            Response::HTTP_OK
        );
    }
}
