<?php

namespace WeDevBr\Celcoin\Tests\Integration\TopupsInternational;

use GuzzleHttp\Promise\PromiseInterface;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Http;
use WeDevBr\Celcoin\Clients\CelcoinInternationalTopups;
use WeDevBr\Celcoin\Tests\GlobalStubs;
use WeDevBr\Celcoin\Tests\TestCase;
use WeDevBr\Celcoin\Types\InternationalTopups\Create;

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
                    CelcoinInternationalTopups::CREATE_ENDPOINT,
                ) => self::stubSuccess(),
            ],
        );

        $topups = new CelcoinInternationalTopups();
        $response = $topups->create(
            new Create([
                'phone' => [
                    'number' => 48227030,
                    'countryCode' => 509,
                ],
                'cpfCnpj' => '35914746817',
                'externalNsu' => 123231312,
                'externalTerminal' => '6958',
                'value' => '5.4300',
                'topupProductId' => '5',
            ]),
        );
        $this->assertEquals(0, $response['status']);
    }

    private static function stubSuccess(): PromiseInterface
    {
        return Http::response(
            [
                'NSUnameProvider' => 0,
                'authentication' => 4167,
                'authenticationAPI' => null,
                'receipt' => [
                    'receiptData' => '',
                    'receiptformatted' => "                 TESTE\r\n          PROTOCOLO 0816057734\r\n1          06/04/2022        14:29\r\nTERM 228001 AGENTE 228001 AUTE 04167\r\n----------------------------------------\r\nAUTO 907545       RECARGA INTERNACIONAL\r\nVALOR :R$ 5,43\r\nOPERADORA : DIGICEL HAITI BRL\r\nNUMERO : 50948227030\r\nMOEDA : BRL\r\nVALORLOCAL : \r\nNSU : \r\n----------------------------------------\r\n\r\n",
                ],
                'settleDate' => '0001-01-01T00:00:00',
                'createDate' => '2022-04-06T14:29:27',
                'transactionId' => 816057734,
                'Urlreceipt' => null,
                'errorCode' => '000',
                'message' => null,
                'status' => 0,
            ],
            Response::HTTP_OK,
        );
    }
}
