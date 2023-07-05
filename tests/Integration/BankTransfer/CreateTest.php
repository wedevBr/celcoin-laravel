<?php

namespace Tests\Integration\BankTransfer;

use GuzzleHttp\Promise\PromiseInterface;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Http;
use Tests\GlobalStubs;
use Tests\TestCase;
use WeDevBr\Celcoin\Clients\CelcoinBankTransfer;
use WeDevBr\Celcoin\Enums\AccountTypeEnum;
use WeDevBr\Celcoin\Types\BankTransfer\Create;

class CreateTest extends TestCase
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
                    CelcoinBankTransfer::CREATE_ENDPOINT
                ) => self::stubSuccess()
            ]
        );

        $transfer = new CelcoinBankTransfer();
        $response = $transfer->create(new Create([
            "document" => "35914746817",
            "externalTerminal" => "123",
            "externalNSU" => 123,
            "accountCode" => "379424",
            "digitCode" => "5",
            "branchCode" => "30",
            "name" => "Fulano de tal",
            "value" => 5,
            "bankAccountType" => AccountTypeEnum::CHECKING_ACCOUNT,
            "institutionIspb" => "30306294"
        ]));
        $this->assertEquals(0, $response['status']);
    }

    static private function stubSuccess(): PromiseInterface
    {
        return Http::response(
            [
                "authenticationAPI" => [
                    "bloco1" => "8D.65.EE.39.C4.EA.2A.33",
                    "bloco2" => "DD.3F.15.C8.08.A5.6A.D6",
                    "blocoCompleto" => "8D.65.EE.39.C4.EA.2A.33.DD.3F.15.C8.08.A5.6A.D6",
                ],
                "receipt" => [
                    "receiptData" => null,
                    "receiptformatted" => "\n                 CELCOIN PAGAMENTOS          \n     \n      IHOLD BANK CORRESPONDENTE BANCARIO LTDA\n                PROTOCOLO 817877890          \n                  05/07/2023 23:31           \n      ---------------------------------------\n                   TRANSFERENCIA             \n               CODIGO BANCO: 30306294        \n                    AGENCIA: 30              \n                   CONTA: 3794245            \n                NOME: FULANO DE TAL          \n              CPF / CNPJ: 35914746817        \n                    VALOR: 5,00              \n      ENDTOEND: E139358932023070523310118522827\n     \n      ---------------------------------------\n     \n                    AUTENTICACAO             \n              8D.65.EE.39.C4.EA.2A.33        \n              DD.3F.15.C8.08.A5.6A.D6        \n      ",
                ],
                "destinationAccountData" =>  [
                    "agency" => 30,
                    "institutionCode" => 30306294,
                    "account" => 379424,
                    "accountVerifierDigit" => "5",
                    "document" => "35914746817",
                    "institutionName" => null,
                    "fullName" => "Fulano de tal",
                    "bankAccountType" => 0,
                    "documentType" => "CPF",
                    "value" => 5.0,
                ],
                "createDate" => "2023-07-05T23:31:27.5883691+00:00",
                "dateNextLiquidation" => "",
                "nextSettle" => false,
                "transactionId" => 817877890,
                "endToEnd" => "E1393589320230705233101185228273",
                "urlreceipt" => "",
                "errorCode" => "000",
                "message" => "SUCESSO",
                "status" => "0",
            ],
            Response::HTTP_OK
        );
    }
}
