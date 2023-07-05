<?php

namespace Tests\Integration\Topups;

use GuzzleHttp\Promise\PromiseInterface;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Http;
use Tests\GlobalStubs;
use Tests\TestCase;
use WeDevBr\Celcoin\Clients\CelcoinTopups;
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
                    CelcoinTopups::CREATE_ENDPOINT
                ) => self::stubSuccess()
            ]
        );

        $topups = new CelcoinTopups();
        $response = $topups->create(new Create([
            "externalTerminal" => "1123123123",
            "externalNsu" => 1234,
            "topupData" => [
                "value" => 85.99
            ],
            "cpfCnpj" => "65419636069",
            "signerCode" => "1234567",
            "providerId" => 2125,
            "phone" => [
                "stateCode" => 15,
                "countryCode" => 55,
                "number" => 993134307
            ]
        ]));
        $this->assertEquals(0, $response['status']);
    }

    static private function stubSuccess(): PromiseInterface
    {
        return Http::response(
            [
                "NSUnameProvider" => 0,
                "authentication" => 5878,
                "authenticationAPI" => null,
                "receipt" => [
                    "receiptData" => "",
                    "receiptformatted" => "        AMBIENTE DE HOMOLOGACAO\r\n          PROTOCOLO 0002751870\r\n1          11/03/2022        09:24\r\nTERM 228005 AGENTE 228005 AUTE 05878\r\n----------------------------------------\r\nAUTO 806689                            \r\n<VIA1>\r\nESTE CUPOM NAO TEM VALOR FISCAL\r\n</VIA1>PRODUTO: R$ 85,99 - XBOX LIVE 3 MESES\r\n<VIA1>VALOR: R$  85,99\r\nPIN: 6365-4427-6400-1327\r\nSERIE: 00000000\r\nTELEFONE:  15 993134307\r\n\r\n      COMO RESGATAR O CODIGO XBOX:\r\n       VISITE XBOX.COM/REDEEMCODE\r\nDIGITE O CODIGO DESTE RECIBO E COMECE A \r\n                 USAR!\r\n                    \r\n    APOS O USO, INUTILIZE ESTE CUPOM\r\nIS2B - INTEGRATED SOLUTIONS TO BUSINESS\r\n                    \r\n                    \r\n                    \r\n                    \r\n</VIA1>----------------------------------------\r\n\r\n"
                ],
                "settleDate" => "2022-03-11T00:00:00",
                "createDate" => "2022-03-11T09:24:38",
                "transactionId" => 9172370,
                "Urlreceipt" => null,
                "errorCode" => "000",
                "message" => null,
                "status" => 0
            ],
            Response::HTTP_OK
        );
    }
}
