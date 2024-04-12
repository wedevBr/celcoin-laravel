<?php

namespace WeDevBr\Celcoin\Tests\Integration\BAAS\PIXKey;

use GuzzleHttp\Promise\PromiseInterface;
use Illuminate\Support\Facades\Http;
use Symfony\Component\HttpFoundation\Response;
use WeDevBr\Celcoin\Clients\CelcoinBAASPIX;
use WeDevBr\Celcoin\Tests\GlobalStubs;
use WeDevBr\Celcoin\Tests\TestCase;

class BAASPIXDeletePixKeyTest extends TestCase
{
    final public function testSuccess(): void
    {
        Http::fake(
            [
                config('celcoin.login_url') => GlobalStubs::loginResponse(),
                sprintf(
                    '%s%s*',
                    config('api_url'),
                    sprintf(CelcoinBAASPIX::DELETE_PIX_KEY_ENDPOINT, '0f4f01e4-53ec-4c7c-9c50-334621c19cb3'),
                ) => self::stubSuccess(),
            ],
        );

        $pix = new CelcoinBAASPIX();
        $response = $pix->deletePixKey('300541976902', '0f4f01e4-53ec-4c7c-9c50-334621c19cb3');

        $this->assertEquals('SUCCESS', $response['status']);
    }

    private static function stubSuccess(): PromiseInterface
    {
        return Http::response(
            [
                'status' => 'SUCCESS',
                'version' => '1.0.0',
            ],
            Response::HTTP_OK,
        );
    }
}
