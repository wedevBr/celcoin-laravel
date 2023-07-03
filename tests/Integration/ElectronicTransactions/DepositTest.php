<?php

namespace Tests\Integration\ElectronicTransactions;

use GuzzleHttp\Promise\PromiseInterface;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Http;
use Tests\GlobalStubs;
use Tests\TestCase;
use WeDevBr\Celcoin\Clients\CelcoinElectronicTransactions;
use WeDevBr\Celcoin\Types\ElectronicTransactions\Deposit;
use WeDevBr\Celcoin\Types\ElectronicTransactions\Withdraw;

class DepositTest extends TestCase
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
                    CelcoinElectronicTransactions::DEPOSIT_ENDPOINT
                ) => self::stubSuccess()
            ]
        );

        $electronicTransaction = new CelcoinElectronicTransactions();
        $response = $electronicTransaction->deposit(new Deposit([
            "externalNSU" => 1234,
            "externalTerminal" => "11122233344",
            "payerContact" => "944445555",
            "payerDocument" => "11122233344",
            "transactionIdentifier" => "Banco24Horas/DepositoDigital/v1/a0a0d296-3754-454d-bc0c-b1c4d114467f/ea9dd655/1240004",
            "payerName" => "Fulano de tal",
            "namePartner" => "TECBAN_BANCO24H",
            "value" => 150
        ]));

        $this->assertEquals(0, $response['status']);
    }

    static private function stubSuccess(): PromiseInterface
    {
        return Http::response(
            [
                "BarCodeBase64" => null,
                "convenant" => "0720",
                "orderNumber" => "a0a0d296-3754-454d-bc0c-b1c4d114467f",
                "product" => null,
                "transactionId" => 816055940,
                "QRCodeBase64" => null,
                "token" => null,
                "value" => 150,
                "errorCode" => "000",
                "message" => "SUCESSO",
                "status" => 0
            ],
            Response::HTTP_OK
        );
    }
}
