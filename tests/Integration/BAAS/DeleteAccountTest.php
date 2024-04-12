<?php

namespace WeDevBr\Celcoin\Tests\Integration\BAAS;

use GuzzleHttp\Promise\PromiseInterface;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Http;
use WeDevBr\Celcoin\Clients\CelcoinBAAS;
use WeDevBr\Celcoin\Tests\GlobalStubs;
use WeDevBr\Celcoin\Tests\TestCase;

class DeleteAccountTest extends TestCase
{
    /**
     * @return void
     */
    public function testSuccess()
    {
        $params = http_build_query(
            [
                'Account' => '12345',
                'DocumentNumber' => null,
                'Reason' => 'Segurança',
            ],
        );
        Http::fake(
            [
                config('celcoin.login_url') => GlobalStubs::loginResponse(),
                sprintf(
                    '%s%s*',
                    config('api_url'),
                    sprintf(CelcoinBAAS::DELETE_ACCOUNT, $params),
                ) => self::stubSuccess(),
            ],
        );

        $baas = new CelcoinBAAS();
        $response = $baas->deleteAccount('Segurança', '12345');

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
