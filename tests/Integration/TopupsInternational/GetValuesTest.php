<?php

namespace WeDevBr\Celcoin\Tests\Integration\TopupsInternational;

use GuzzleHttp\Promise\PromiseInterface;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Http;
use WeDevBr\Celcoin\Clients\CelcoinInternationalTopups;
use WeDevBr\Celcoin\Tests\GlobalStubs;
use WeDevBr\Celcoin\Tests\TestCase;

class GetValuesTest extends TestCase
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
                    CelcoinInternationalTopups::GET_VALUES_ENDPOINT,
                ) => self::stubSuccess(),
            ],
        );

        $topups = new CelcoinInternationalTopups();
        $response = $topups->getValues(509, '48227030');
        $this->assertEquals(0, $response['status']);
    }

    private static function stubSuccess(): PromiseInterface
    {
        return Http::response(
            [
                'data' => [
                    'quotation' => [
                        'purchase' => '5.2468',
                        'quotationId' => '206353',
                        'quotationDateTime' => '2021-08-13T13:04:27.62',
                        'description' => 'PTAX (Banco Central)',
                        'spread' => '10',
                        'sale' => '5.2474',
                    ],
                    'baseCurrency' => 'BRL',
                    'destinyCurrency' => 'BRL',
                    'localCurrency' => 'HTG',
                    'number' => '50948227030',
                    'nameProvider' => 'Digicel Haiti BRL',
                    'country' => 'Haiti',
                    'products' => [],
                ],
                'errorCode' => '000',
                'message' => 'SUCESSO',
                'status' => 0,
            ],
            Response::HTTP_OK,
        );
    }
}
