<?php

namespace WeDevBr\Celcoin\Tests\Integration\Assistant;

use GuzzleHttp\Promise\PromiseInterface;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Http;
use WeDevBr\Celcoin\Clients\CelcoinAssistant;
use WeDevBr\Celcoin\Tests\GlobalStubs;
use WeDevBr\Celcoin\Tests\TestCase;

class GetReceiptTest extends TestCase
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
                    sprintf(CelcoinAssistant::GET_RECEIPT_ENDPOINT, 1),
                ) => self::stubSuccess(),
            ],
        );

        $assistant = new CelcoinAssistant();
        $response = $assistant->getReceipt(1);
        $this->assertEquals(0, $response['status']);
    }

    static private function stubSuccess(): PromiseInterface
    {
        return Http::response(
            [
                "isExpired" => true,
                "convenant" => "CELCOIN",
                "authentication" => 3470,
                "receipt" => [
                    "receiptData" => "",
                    "receiptformatted" => "          PROTOCOLO 0007098104\r\n1          24/06/2021        17:49\r\nTERM 228005 AGENTE 228005 AUTE 06153\r\n----------------------------------------\r\nAUTO 919755                   PAGAMENTO\r\n                    \r\n              GENERICA CC\r\n      82610000000-7 30700022001-1      \r\n         06104045000-1 03202180003-5\r\n----------------------------------------\r\nDATA DE LIQUIDACAO           24/06/2021\r\nVALOR COBRADO                     30,70\r\n\r\n    VALIDO COMO RECIBO DE PAGAMENTO\r\n----------------------------------------\r\n              AUTENTICACAO\r\n        2D.46.A6.46.99.A4.22.2D\r\n        86.32.67.47.DC.B8.B8.E1\r\n----------------------------------------\r\n \r\nCONSULTE A AUTENTICA??O EM:\r\nCELCOIN.COM.BR/AUTENTICACAO\r\n\r\n",
                ],
                "authenticationAPI" => [
                    "bloco1" => "CC.D7.0F.AF.BF.76.8B.D8",
                    "bloco2" => "E3.30.DC.BF.C5.FB.5F.54",
                    "blocoCompleto" => "CC.D7.0F.AF.BF.76.8B.D8.E3.30.DC.BF.C5.FB.5F.54",
                ],
                "settleDate" => "2021-06-24T00:00:00",
                "createDate" => "2021-06-24T11:31:10",
                "transactionId" => 7098104,
                "urlreceipt" => "https://www.celcoin.com.br",
                "errorCode" => "000",
                "message" => "SUCESSO",
                "status" => 0,
            ],
            Response::HTTP_OK,
        );
    }
}
