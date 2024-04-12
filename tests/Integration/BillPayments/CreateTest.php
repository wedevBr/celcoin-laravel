<?php

namespace WeDevBr\Celcoin\Tests\Integration\BillPayments;

use GuzzleHttp\Promise\PromiseInterface;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Http;
use WeDevBr\Celcoin\Clients\CelcoinBillPayment;
use WeDevBr\Celcoin\Tests\GlobalStubs;
use WeDevBr\Celcoin\Tests\TestCase;
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
                    CelcoinBillPayment::CREATE_ENDPOINT,
                ) => self::stubSuccess(),
            ],
        );

        $payment = new CelcoinBillPayment();
        $response = $payment->create(
            new Create([
                'externalNSU' => 1234,
                'externalTerminal' => 'teste2',
                'cpfcnpj' => '51680002000100',
                'billData' => [
                    'value' => 1500,
                    'originalValue' => 1500,
                    'valueWithDiscount' => 0,
                    'valueWithAdditional' => 0,
                ],
                'barCode' => [
                    'type' => 2,
                    'digitable' => '34191090080025732445903616490003691150000020000',
                    'barCode' => '',
                ],
                'dueDate' => '2023-07-14',
                'transactionIdAuthorize' => 817958488,
            ]),
        );
        $this->assertArrayHasKey('authenticationAPI', $response);
    }

    private static function stubSuccess(): PromiseInterface
    {
        return Http::response(
            [
                'convenant' => 'BANCO VOTORANTIM',
                'isExpired' => false,
                'authentication' => 7295,
                'authenticationAPI' => [
                    'Bloco1' => 'F6.4E.2B.DD.C4.D9.5F.4D',
                    'Bloco2' => '4B.FB.E0.D9.1B.84.C8.EA',
                    'BlocoCompleto' => 'F6.4E.2B.DD.C4.D9.5F.4D.4B.FB.E0.D9.1B.84.C8.EA',
                ],
                'receipt' => [
                    'receiptData' => '',
                    'receiptformatted' => "\nTESTE\n                PROTOCOLO 0817957611\n      1          13/07/2023        18:08\n      TERM 228001 AGENTE 228001 AUTE 07295\n      ----------------------------------------\n      AUTO 975550           RECEBIMENTO CONTA\n                          \n                  BANCO ITAU S.A.\n              34191.09008  00257.324459      \n             03616.490003  6 91150000020000\n      \n      BENEF:   BENEFICIARIO AMBIENTE HOMOLOGA\n      CPF/CNPJ:            13.935.893/0001-09\n      PAGADOR: PAGADOR AMBIENTE DE HOMOLOGACA\n      CPF/CNPJ:            13.935.893/0001-09\n      ----------------------------------------\n      DATA DE VENCIMENTO           14/07/2023\n      DATA DO PAGAMENTO            13/07/2023\n      DATA DE LIQUIDACAO           13/07/2023\n      VALOR TITULO                    1500,00\n      VALOR COBRADO                   1500,00\n      \n          VALIDO COMO RECIBO DE PAGAMENTO\n      ----------------------------------------\n                    AUTENTICACAO\n              F6.4E.2B.DD.C4.D9.5F.4D\n              4B.FB.E0.D9.1B.84.C8.EA\n      ----------------------------------------\n      \n      ",
                ],
                'settleDate' => '2023-07-13T00:00:00',
                'createDate' => '2023-07-13T18:08:15',
                'transactionId' => 817957611,
                'Urlreceipt' => null,
                'errorCode' => '000',
                'message' => null,
                'status' => 0,
            ],
            Response::HTTP_OK,
        );
    }
}
