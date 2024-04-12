<?php

namespace WeDevBr\Celcoin\Tests\Integration\BAAS;

use GuzzleHttp\Promise\PromiseInterface;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Http;
use WeDevBr\Celcoin\Clients\CelcoinBAAS;
use WeDevBr\Celcoin\Tests\GlobalStubs;
use WeDevBr\Celcoin\Tests\TestCase;

class ActiveAccountTest extends TestCase
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
                    sprintf(CelcoinBAAS::ACTIVE_ACCOUNT, '300541976902', null),
                ) => self::stubSuccess(),
            ],
        );

        $baas = new CelcoinBAAS();
        $response = $baas->activeAccount('Ativando', '300541976902');

        $this->assertEquals('SUCCESS', $response['status']);
    }

    private static function stubSuccess(): PromiseInterface
    {
        return Http::response(
            [
                'version' => '1.0.0',
                'status' => 'SUCCESS',
            ],
            Response::HTTP_OK,
        );
    }
}
