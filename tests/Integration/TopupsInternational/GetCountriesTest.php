<?php

namespace WeDevBr\Celcoin\Tests\Integration\TopupsInternational;

use GuzzleHttp\Promise\PromiseInterface;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Http;
use WeDevBr\Celcoin\Clients\CelcoinInternationalTopups;
use WeDevBr\Celcoin\Tests\GlobalStubs;
use WeDevBr\Celcoin\Tests\TestCase;

class GetCountriesTest extends TestCase
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
                    CelcoinInternationalTopups::GET_COUNTRIES_ENDPOINT,
                ) => self::stubSuccess(),
            ],
        );

        $topups = new CelcoinInternationalTopups();
        $response = $topups->getCountries();
        $this->assertEquals(0, $response['status']);
    }

    private static function stubSuccess(): PromiseInterface
    {
        return Http::response(
            [
                'countrys' => [
                    [
                        'flagURL' => 'https://restcountries.eu/data/guf.svg',
                        'code' => '+594',
                        'name' => 'French Guiana',
                    ],
                ],
                'errorCode' => '000',
                'message' => 'SUCESSO',
                'status' => 0,
            ],
            Response::HTTP_OK,
        );
    }
}
