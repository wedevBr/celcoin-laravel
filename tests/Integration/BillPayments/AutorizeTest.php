<?php

namespace WeDevBr\Celcoin\Tests\Integration\BillPayments;

use GuzzleHttp\Promise\PromiseInterface;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Http;
use WeDevBr\Celcoin\Clients\CelcoinBillPayment;
use WeDevBr\Celcoin\Tests\GlobalStubs;
use WeDevBr\Celcoin\Tests\TestCase;
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
                    CelcoinBillPayment::AUTHORIZE_ENDPOINT,
                ) => self::stubSuccess(),
            ],
        );

        $payment = new CelcoinBillPayment();
        $response = $payment->authorize(
            new Authorize([
                "externalTerminal" => "teste2",
                "externalNSU" => 1234,
                "barCode" => [
                    "type" => 2,
                    "digitable" => "34191090080025732445903616490003691150000020000",
                    "barCode" => "",
                ],
            ]),
        );
        $this->assertArrayHasKey('registerData', $response);
    }

    static private function stubSuccess(): PromiseInterface
    {
        return Http::response(
            [
                "assignor" => "BANCO ITAU S.A.",
                "registerData" => [
                    "documentRecipient" => "13.935.893/0001-09",
                    "documentPayer" => "13.935.893/0001-09",
                    "payDueDate" => "2023-08-12T00:00:00",
                    "nextBusinessDay" => null,
                    "dueDateRegister" => "2023-07-14T00:00:00",
                    "allowChangeValue" => true,
                    "recipient" => "BENEFICIARIO AMBIENTE HOMOLOGACAO",
                    "payer" => "PAGADOR AMBIENTE DE HOMOLOGACAO",
                    "discountValue" => 0.0,
                    "interestValueCalculated" => 0.0,
                    "maxValue" => 1500.0,
                    "minValue" => 0.0,
                    "fineValueCalculated" => 0.0,
                    "originalValue" => 1500.0,
                    "totalUpdated" => 1500.0,
                    "totalWithDiscount" => 0.0,
                    "totalWithAdditional" => 0.0,
                ],
                "settleDate" => "13/07/2023",
                "dueDate" => "2023-07-14T00:00:00Z",
                "endHour" => "20:00",
                "initeHour" => "07:00",
                "nextSettle" => "N",
                "digitable" => "34191090080025732445903616490003691150000020000",
                "transactionId" => 817958431,
                "type" => 2,
                "value" => 200.0,
                "maxValue" => null,
                "minValue" => null,
                "errorCode" => "000",
                "message" => null,
                "status" => 0,
            ],
            Response::HTTP_OK,
        );
    }
}
