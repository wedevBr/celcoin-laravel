<?php

namespace Tests\Integration\BillPayments;

use GuzzleHttp\Promise\PromiseInterface;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Http;
use Tests\GlobalStubs;
use Tests\TestCase;
use WeDevBr\Celcoin\Clients\CelcoinBillPayment;
use WeDevBr\Celcoin\Types\BillPayments\Create;

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
                    CelcoinBillPayment::CREATE_ENDPOINT
                ) => self::stubSuccess()
            ]
        );

        $payment = new CelcoinBillPayment();
        $response = $payment->create(new Create([
            "externalNSU" => 1234,
            "externalTerminal" => "t2",
            "cpfcnpj" => "51680002000100",
            "billData" => [
                "value" => 202.71,
                "originalValue" => 202.71,
                "valueWithDiscount" => 0,
                "valueWithAdditional" => 0
            ],
            "barCode" => [
                "type" => 2,
                "digitable" => "03399853012970000135607559001016189020000020271",
                "barCode" => ""
            ],
            "dueDate" => "2022-02-20",
            "transactionIdAuthorize" => 9087400
        ]));
        $this->assertArrayHasKey('authenticationAPI', $response);
    }

    static private function stubSuccess(): PromiseInterface
    {
        return Http::response(
            [
                "convenant" => "BANCO VOTORANTIM",
                "isExpired" => false,
                "authentication" => 2604,
                "authenticationAPI" => [
                    "Bloco1" => "FB.DF.50.98.3E.AD.70.4F",
                    "Bloco2" => "53.41.A2.9D.06.9E.C1.59",
                    "BlocoCompleto" => "FB.DF.50.98.3E.AD.70.4F.53.41.A2.9D.06.9E.C1.59"
                ],
                "receipt" => [
                    "receiptData" => "",
                    "receiptformatted" => "        AMBIENTE DE HOMOLOGACAO\r\n          PROTOCOLO 0009087426\r\n1          15/02/2022        16:50\r\nTERM 228005 AGENTE 228005 AUTE 02604\r\n----------------------------------------\r\nAUTO 846644           RECEBIMENTO CONTA\r\n                    \r\n          BANCO SANTANDER S.A\r\n        03399.85301  29700.001356      \r\n       07559.001016  1 89020000020271\r\n\r\nBENEF:   BENEFICIARIO AMBIENTE HOMOLOGA\r\nCPF/CNPJ:            21.568.259/0001-00\r\nPAGADOR:   PAGADOR AMBIENTE HOMOLOGACAO\r\nCPF/CNPJ:            96.906.497/0001-00\r\n----------------------------------------\r\nDATA DE VENCIMENTO           20/02/2022\r\nDATA DO PAGAMENTO            15/02/2022\r\nDATA DE LIQUIDACAO           15/02/2022\r\nVALOR TITULO                     202,71\r\nVALOR COBRADO                    202,71\r\n<VIA1>\r\n \r\nVALIDO COMO RECIBO DE PAGAMENTO\r\n----------------------------------------\r\nAUTENTICACAO\r\nFB.DF.50.98.3E.AD.70.4F\r\n53.41.A2.9D.06.9E.C1.59\r\n</VIA1>----------------------------------------\r\n<VIA1> \r\nCONSULTE A AUTENTICA??O EM:\r\nCELCOIN.COM.BR/AUTENTICACAO\r\n</VIA1>\r\n"
                ],
                "settleDate" => "2022-02-15T00:00:00",
                "createDate" => "2022-02-15T16:50:04",
                "transactionId" => 9087426,
                "Urlreceipt" => null,
                "errorCode" => "000",
                "message" => null,
                "status" => 0
            ],
            Response::HTTP_OK
        );
    }
}
