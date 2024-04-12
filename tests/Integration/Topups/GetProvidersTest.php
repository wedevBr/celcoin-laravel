<?php

namespace WeDevBr\Celcoin\Tests\Integration\Topups;

use GuzzleHttp\Promise\PromiseInterface;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Http;
use WeDevBr\Celcoin\Clients\CelcoinTopups;
use WeDevBr\Celcoin\Enums\TopupProvidersCategoryEnum;
use WeDevBr\Celcoin\Enums\TopupProvidersTypeEnum;
use WeDevBr\Celcoin\Tests\GlobalStubs;
use WeDevBr\Celcoin\Tests\TestCase;
use WeDevBr\Celcoin\Types\Topups\Providers;

class GetProvidersTest extends TestCase
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
                    CelcoinTopups::GET_PROVIDERS_ENDPOINT,
                ) => self::stubSuccess(),
            ],
        );

        $topups = new CelcoinTopups();
        $response = $topups->getProviders(
            new Providers([
                'stateCode' => 13,
                'type' => TopupProvidersTypeEnum::ALL,
                'category' => TopupProvidersCategoryEnum::ALL,
            ]),
        );
        $this->assertArrayHasKey('providers', $response);
    }

    private static function stubSuccess(): PromiseInterface
    {
        return Http::response(
            [
                'providers' => [
                    [
                        'category' => 2,
                        'name' => 'Blizzard',
                        'providerId' => 2139,
                        'RegionaisnameProvider' => [],
                        'TipoRecarganameProvider' => 1,
                        'maxValue' => 0,
                        'minValue' => 0,
                    ],
                    [
                        'category' => 2,
                        'name' => 'Boa Compra',
                        'providerId' => 2107,
                        'RegionaisnameProvider' => [],
                        'TipoRecarganameProvider' => 1,
                        'maxValue' => 0,
                        'minValue' => 0,
                    ],
                ],
            ],
            Response::HTTP_OK,
        );
    }
}
