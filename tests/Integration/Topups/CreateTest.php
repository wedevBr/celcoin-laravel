<?php

namespace WeDevBr\Celcoin\Tests\Integration\Topups;

use GuzzleHttp\Promise\PromiseInterface;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Http;
use WeDevBr\Celcoin\Clients\CelcoinTopups;
use WeDevBr\Celcoin\Tests\GlobalStubs;
use WeDevBr\Celcoin\Tests\TestCase;
use WeDevBr\Celcoin\Types\Topups\Create;

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
                    '%s%s*',
                    config('api_url'),
                    CelcoinTopups::CREATE_ENDPOINT,
                ) => self::stubSuccess(),
            ],
        );

        $topups = new CelcoinTopups();
        $response = $topups->create(
            new Create([
                'externalTerminal' => 'teste2',
                'externalNsu' => 1234,
                'topupData' => [
                    'value' => 15,
                ],
                'cpfCnpj' => '19941206066',
                'signerCode' => '1234567',
                'providerId' => 2086,
                'phone' => [
                    'stateCode' => 31,
                    'countryCode' => 55,
                    'number' => 991452026,
                ],
            ]),
        );
        $this->assertEquals(0, $response['status']);
    }

    private static function stubSuccess(): PromiseInterface
    {
        return Http::response(
            [
                'NSUnameProvider' => 610761,
                'authentication' => 6003,
                'authenticationAPI' => [
                    'Bloco1' => 'DA.53.00.C9.57.A2.6E.8E',
                    'Bloco2' => '8A.DB.0B.8E.17.F1.78.97',
                    'BlocoCompleto' => 'DA.53.00.C9.57.A2.6E.8E.8A.DB.0B.8E.17.F1.78.97',
                ],
                'receipt' => [
                    'receiptData' => '',
                    'receiptformatted' => "\n                       TESTE\n                PROTOCOLO 0817981234\n      1          14/07/2023        17:46\n      TERM 228001 AGENTE 228001 AUTE 06003\n      ----------------------------------------\n      AUTO 987535                     RECARGA\n      \n      PRODUTO: TIM\n      ASSINANTE: 1234567\n      TELEFONE:  11 941497981\n      NSU OPERADORA: 610761\n      DATA:  14/07/2023 17:46\n      VALOR: R$  15,00\n      \n      VIVO TURBO: INTERNET + LIGACOES E SMS\n      ILIMITADOS PARA VIVO (CEL E FIXO, USANDO\n      O 15)APENAS R$9,99 POR SEMANA. LIGUE\n      *9003 E CADASTRE SE!\n      ----------------------------------------\n                    AUTENTICACAO\n              DA.53.00.C9.57.A2.6E.8E\n              8A.DB.0B.8E.17.F1.78.97\n      ----------------------------------------\n      \n      ",
                ],
                'settleDate' => '2023-07-14T00:00:00',
                'createDate' => '2023-07-14T17:46:43',
                'transactionId' => 817981234,
                'Urlreceipt' => null,
                'errorCode' => '000',
                'message' => null,
                'status' => 0,
            ],
            Response::HTTP_OK,
        );
    }
}
