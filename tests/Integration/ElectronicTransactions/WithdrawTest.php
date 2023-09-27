<?php

namespace WeDevBr\Celcoin\Tests\Integration\ElectronicTransactions;

use GuzzleHttp\Promise\PromiseInterface;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Http;
use WeDevBr\Celcoin\Clients\CelcoinElectronicTransactions;
use WeDevBr\Celcoin\Tests\GlobalStubs;
use WeDevBr\Celcoin\Tests\TestCase;
use WeDevBr\Celcoin\Types\ElectronicTransactions\Withdraw;

class WithdrawTest extends TestCase
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
                    CelcoinElectronicTransactions::WITHDRAW_ENDPOINT,
                ) => self::stubSuccess(),
            ],
        );

        $electronicTransaction = new CelcoinElectronicTransactions();
        $response = $electronicTransaction->withdraw(
            new Withdraw([
                "externalNSU" => 1234,
                "externalTerminal" => "teste2",
                "receivingContact" => "944445555",
                "receivingDocument" => "11122233344",
                "transactionIdentifier" => "05e07b49-f57a-453c-b5e7-46ebe7bc5037",
                "receivingName" => "Fulano de tal",
                "namePartner" => "TECBAN_BANCO24H",
                "value" => 150,
                "secondAuthentication" => [
                    "dataForSecondAuthentication" => 12345,
                    "textForSecondIdentification" => "ID do usuário",
                    "useSecondAuthentication" => false,
                ],
            ]),
        );

        $this->assertEquals(0, $response['status']);
    }

    static private function stubSuccess(): PromiseInterface
    {
        return Http::response(
            [
                "BarCodeBase64" => null,
                "convenant" => "0860",
                "externalWithdrawIdentifier" => "",
                "transactionIdentifier" => "05e07b49-f57a-453c-b5e7-46ebe7bc5037",
                "orderNumber" => null,
                "product" => null,
                "transactionId" => 817981834,
                "QRCodeBase64" => null,
                "token" => null,
                "value" => 150,
                "errorCode" => "000",
                "message" => "SUCESSO",
                "status" => 0,
            ],
            Response::HTTP_OK,
        );
    }
}
