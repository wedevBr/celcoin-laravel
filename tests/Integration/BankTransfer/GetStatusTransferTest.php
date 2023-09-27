<?php

namespace WeDevBr\Celcoin\Tests\Integration\BankTransfer;

use GuzzleHttp\Promise\PromiseInterface;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Http;
use WeDevBr\Celcoin\Clients\CelcoinBankTransfer;
use WeDevBr\Celcoin\Tests\GlobalStubs;
use WeDevBr\Celcoin\Tests\TestCase;

class GetStatusTransferTest extends TestCase
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
                    sprintf(CelcoinBankTransfer::GET_STATUS_TRANSFER_ENDPOINT, 817981763),
                ) => self::stubSuccess(),
            ],
        );

        $transfer = new CelcoinBankTransfer();
        $response = $transfer->getStatusTransfer(817981763);
        $this->assertEquals(0, $response['status']);
    }

    static private function stubSuccess(): PromiseInterface
    {
        return Http::response(
            [
                "authentication" => 0,
                "createDate" => "2023-07-14T18:15:24",
                "refundReason" => "Value in Creditor Identifier is incorrect",
                "externalNSU" => "1234",
                "transactionId" => 817981763,
                "stateCompensation" => "Processado com erro",
                "externalTerminal" => "teste2",
                "typeTransactions" => null,
                "errorCode" => "000",
                "message" => "SUCESSO",
                "status" => 0,
            ],
            Response::HTTP_OK,
        );
    }
}
