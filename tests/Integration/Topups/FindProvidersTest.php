<?php

namespace WeDevBr\Celcoin\Tests\Integration\Topups;

use GuzzleHttp\Promise\PromiseInterface;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Http;
use WeDevBr\Celcoin\Clients\CelcoinTopups;
use WeDevBr\Celcoin\Tests\GlobalStubs;
use WeDevBr\Celcoin\Tests\TestCase;

class FindProvidersTest extends TestCase
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
                    CelcoinTopups::FIND_PROVIDERS_ENDPOINT,
                ) => self::stubSuccess(),
            ],
        );

        $topups = new CelcoinTopups();
        $response = $topups->findProviders(31, 991452026);
        $this->assertEquals(0, $response['status']);
    }

    private static function stubSuccess(): PromiseInterface
    {
        return Http::response(
            [
                'nameProvider' => 'Vivo',
                'providerId' => 2088,
                'errorCode' => '000',
                'message' => 'SUCESSO',
                'status' => 0,
            ],
            Response::HTTP_OK,
        );
    }
}
