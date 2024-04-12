<?php

namespace WeDevBr\Celcoin\Tests\Integration\Topups;

use GuzzleHttp\Promise\PromiseInterface;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Http;
use WeDevBr\Celcoin\Clients\CelcoinTopups;
use WeDevBr\Celcoin\Tests\GlobalStubs;
use WeDevBr\Celcoin\Tests\TestCase;
use WeDevBr\Celcoin\Types\Topups\ProvidersValues;

class GetProviderValueTest extends TestCase
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
                    CelcoinTopups::GET_PROVIDER_VALUES_ENDPOINT,
                ) => self::stubSuccess(),
            ],
        );

        $topups = new CelcoinTopups();
        $response = $topups->getProviderValues(
            new ProvidersValues([
                'stateCode' => 13,
                'providerId' => '2125',
            ]),
        );
        $this->assertEquals(0, $response['status']);
    }

    private static function stubSuccess(): PromiseInterface
    {
        return Http::response(
            [
                'value' => [
                    [
                        'properties' => null,
                        'code' => 0,
                        'cost' => 0,
                        'detail' => '',
                        'productName' => 'R$ 85,99 - Xbox Live 3 meses',
                        'checkSum' => -18913591,
                        'dueProduct' => 0,
                        'valueBonus' => 0,
                        'maxValue' => 85.99,
                        'minValue' => 85.99,
                    ],
                    [
                        'properties' => null,
                        'code' => 0,
                        'cost' => 0,
                        'detail' => '',
                        'productName' => 'R$ 171,98 - Xbox Live 6 meses',
                        'checkSum' => -2147483640,
                        'dueProduct' => 0,
                        'valueBonus' => 0,
                        'maxValue' => 171.89,
                        'minValue' => 171.98,
                    ],
                    [
                        'properties' => null,
                        'code' => 0,
                        'cost' => 0,
                        'detail' => '',
                        'productName' => 'R$ 199,00 - Xbox Live 12 meses',
                        'checkSum' => -18913591,
                        'dueProduct' => 0,
                        'valueBonus' => 0,
                        'maxValue' => 199,
                        'minValue' => 199,
                    ],
                ],
                'externalNsuQuery' => null,
                'errorCode' => '000',
                'message' => 'SUCESSO',
                'status' => 0,
            ],
            Response::HTTP_OK,
        );
    }
}
