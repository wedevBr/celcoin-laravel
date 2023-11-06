<?php

namespace WeDevBr\Celcoin\Tests\Integration\BAAS;

use GuzzleHttp\Promise\PromiseInterface;
use Illuminate\Support\Facades\Http;
use WeDevBr\Celcoin\Clients\CelcoinBAASBillPayment;
use WeDevBr\Celcoin\Enums\BarCodeTypeEnum;
use WeDevBr\Celcoin\Tests\GlobalStubs;
use WeDevBr\Celcoin\Tests\TestCase;
use WeDevBr\Celcoin\Types\BAAS\BillPayment;
use WeDevBr\Celcoin\Types\BAAS\GetPaymentStatusRequest;
use WeDevBr\Celcoin\Types\BillPayments\BarCode;

class BillPaymentTest extends TestCase
{
    public function testSuccess(): void
    {
        Http::fake(
            [
                config('celcoin.login_url') => GlobalStubs::loginResponse(),
                sprintf(
                    '%s%s',
                    config('api_url'),
                    CelcoinBAASBillPayment::MAKE_PAYMENT_ENDPOINT,
                ) => self::makePaymentStubSuccess(),
                sprintf(
                    '%s%s%s',
                    config('api_url'),
                    CelcoinBAASBillPayment::GET_PAYMENT_STATUS,
                    '*'
                ) => self::getPaymentStubSuccess(),
            ],
        );

        $client = new CelcoinBAASBillPayment();

        $billet = new BillPayment();

        $billet->account = '12345';
        $billet->clientRequestId = '5555';
        $billet->barCodeInfo = new BarCode(['type' => BarCodeTypeEnum::COMPENSATION_FORM, 'digitable' => '23793381286008301352856000063307789840000150000']);
        $billet->transactionIdAuthorize = 1234;
        $billet->amount = '59.9';

        $result = $client->makePayment($billet);


        $this->assertEquals('PROCESSING', $result['status']);
        $this->assertEquals('ce9b8d9b-0617-42e1-b500-80bf9d8154cf', $result['body']['id']);
    }

    public function testGetBilletSuccess(): void
    {
        Http::fake(
            [
                config('celcoin.login_url') => GlobalStubs::loginResponse(),
                sprintf(
                    '%s%s',
                    config('api_url'),
                    CelcoinBAASBillPayment::MAKE_PAYMENT_ENDPOINT,
                ) => self::makePaymentStubSuccess(),
                sprintf(
                    '%s%s%s',
                    config('api_url'),
                    CelcoinBAASBillPayment::GET_PAYMENT_STATUS,
                    '*'
                ) => self::getPaymentStubSuccess(),
            ],
        );

        $client = new CelcoinBAASBillPayment();

        $query = new GetPaymentStatusRequest(['id' => 'ce9b8d9b-0617-42e1-b500-80bf9d8154cf']);

        $result = $client->getPaymentStatus($query);

        $this->assertEquals('CONFIRMED', $result['status']);
        $this->assertEquals('10a806a1-267g-5803-93e3-fc215a8b156f', $result['body']['id']);
    }

    public static function makePaymentStubSuccess(): PromiseInterface
    {
        return Http::response([
            "body" => [
                "id" => "ce9b8d9b-0617-42e1-b500-80bf9d8154cf",
                "clientRequestId" => "5555",
                "amount" => 59.9,
                "transactionIdAuthorize" => 1234,
                "tags" => [
                    [
                        "key" => "PaymentType",
                        "value" => "Contas Internas",
                    ],
                ],
                "barCodeInfo" => [
                    "digitable" => "23793381286008301352856000063307789840000150000",
                ],
            ],
            "status" => "PROCESSING",
            "version" => "1.0.0",
        ], 200);
    }

    public static function getPaymentStubSuccess(): PromiseInterface
    {
        return Http::response([
            "body" => [
                "id" => "10a806a1-267g-5803-93e3-fc215a8b156f",
                "clientRequestId" => "clientRequest01",
                "account" => 321,
                "amount" => 5,
                "transactionIdAuthorize" => 123,
                "hasOccurrence" => false,
                "tags" => [
                    [
                        "key" => "PaymentType",
                        "value" => "Contas Internas",
                    ],
                ],
                "barCodeInfo" => [
                    "digitable" => "xxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxx",
                ],
                "paymentDate" => "2023-09-01T00:00:00Z",
            ],
            "status" => "CONFIRMED",
            "version" => "1.1.0",
        ], 200);
    }
}