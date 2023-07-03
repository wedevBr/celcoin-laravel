<?php

namespace Tests\Integration\ElectronicTransactions;

use GuzzleHttp\Promise\PromiseInterface;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Http;
use Tests\GlobalStubs;
use Tests\TestCase;
use WeDevBr\Celcoin\Clients\CelcoinElectronicTransactions;
use WeDevBr\Celcoin\Types\ElectronicTransactions\Withdraw;
use WeDevBr\Celcoin\Types\ElectronicTransactions\WithdrawToken;

class GenerateWithdrawTokenTest extends TestCase
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
                    CelcoinElectronicTransactions::GENERATE_WITHDRAW_TOKEN_ENDPOINT
                ) => self::stubSuccess()
            ]
        );

        $electronicTransaction = new CelcoinElectronicTransactions();
        $response = $electronicTransaction->generateWithdrawToken(new WithdrawToken([
            "externalNSU" => 1234,
            "externalTerminal" => "11122233344",
            "receivingDocument" => "11122233344",
            "receivingName" => "Fulano de tal",
            "value" => 150,
        ]));

        $this->assertEquals(0, $response['status']);
    }

    static private function stubSuccess(): PromiseInterface
    {
        return Http::response(
            [
                "convenant" => "0720",
                "transactionIdentifier" => "05e07b49-f57a-453c-b5e7-46ebe7bc5037",
                "transactionId" => "816055940",
                "token" => "string",
                "value" => "150",
                "erroCode" => "000",
                "message" => "SUCCESS",
                "status" => 0
            ],
            Response::HTTP_OK
        );
    }
}
