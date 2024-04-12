<?php

namespace WeDevBr\Celcoin\Tests\Integration\BAAS\PIXKey;

use GuzzleHttp\Promise\PromiseInterface;
use Illuminate\Support\Facades\Http;
use Symfony\Component\HttpFoundation\Response;
use WeDevBr\Celcoin\Clients\CelcoinBAASPIX;
use WeDevBr\Celcoin\Tests\GlobalStubs;
use WeDevBr\Celcoin\Tests\TestCase;
use WeDevBr\Celcoin\Types\BAAS\RegisterPixKey;

class BAASPIXRegisterPixKeyTest extends TestCase
{
    final public function testSuccess(): void
    {
        Http::fake(
            [
                config('celcoin.login_url') => GlobalStubs::loginResponse(),
                sprintf(
                    '%s%s',
                    config('api_url'),
                    CelcoinBAASPIX::REGISTER_PIX_KEY_ENDPOINT,
                ) => self::stubSuccess(),
            ],
        );

        $pix = new CelcoinBAASPIX();
        $response = $pix->registerPixKey(
            new RegisterPixKey([
                'account' => '300541976910',
                'keyType' => 'EVP',
            ]),
        );

        $this->assertEquals('CONFIRMED', $response['status']);
    }

    private static function stubSuccess(): PromiseInterface
    {
        return Http::response(
            [
                'version' => '1.0.0',
                'status' => 'CONFIRMED',
                'body' => [
                    'keyType' => 'EMAIL',
                    'key' => 'testebaas@cecloin.com.br',
                    'account' => [
                        'participant' => '30306294',
                        'branch' => '0001',
                        'account' => '10545584',
                        'accountType' => 'TRAN',
                        'createDate' => '2020-11-03T06:30:00-03:00',
                    ],
                    'owner' => [
                        'type' => 'NATURAL_PERSON',
                        'documentNumber' => '34335125070',
                        'name' => 'Carlos Henrique da Silva',
                    ],
                ],
            ],
            Response::HTTP_OK,
        );
    }
}
