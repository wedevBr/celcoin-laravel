<?php

namespace Tests\Integration\BankTransfer;

use Carbon\Carbon;
use GuzzleHttp\Promise\PromiseInterface;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Http;
use Tests\GlobalStubs;
use Tests\TestCase;
use WeDevBr\Celcoin\Clients\CelcoinBankTransfer;

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
                    sprintf(CelcoinBankTransfer::GET_STATUS_TRANSFER_ENDPOINT, 817877890)
                ) => self::stubSuccess()
            ]
        );

        $transfer = new CelcoinBankTransfer();
        $response = $transfer->getStatusTransfer(817877890, dataOperacao: new Carbon('2023-07-05T23:31:27.5883691+00:00'));
        $this->assertEquals(0, $response['status']);
    }

    static private function stubSuccess(): PromiseInterface
    {
        return Http::response(
            [
                "authentication" => 0,
                "createDate" => "2023-07-05T20:31:27",
                "refundReason" => "Value in Creditor Identifier is incorrect",
                "externalNSU" => "123",
                "transactionId" => 817877890,
                "stateCompensation" => "Processado com erro",
                "externalTerminal" => "123",
                "typeTransactions" => null,
                "errorCode" => "000",
                "message" => "SUCESSO",
                "status" => 0,
            ],
            Response::HTTP_OK
        );
    }
}
