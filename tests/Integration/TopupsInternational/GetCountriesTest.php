<?php

namespace Tests\Integration\TopupsInternational;

use GuzzleHttp\Promise\PromiseInterface;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Http;
use Tests\GlobalStubs;
use Tests\TestCase;
use WeDevBr\Celcoin\Clients\CelcoinInternationalTopups;

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
                    CelcoinInternationalTopups::GET_COUNTRIES_ENDPOINT
                ) => self::stubSuccess()
            ]
        );

        $topups = new CelcoinInternationalTopups();
        $response = $topups->getCountries();
        $this->assertEquals(0, $response['status']);
    }

    static private function stubSuccess(): PromiseInterface
    {
        return Http::response(
            [
                "countrys" => [
                    [
                        "flagURL" => "https://restcountries.eu/data/guf.svg",
                        "code" => "+594",
                        "name" => "French Guiana",
                    ]
                ],
                "errorCode" => "000",
                "message" => "SUCESSO",
                "status" => 0,
            ],
            Response::HTTP_OK
        );
    }
}
