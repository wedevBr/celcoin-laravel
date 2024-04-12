<?php

namespace WeDevBr\Celcoin\Tests\Integration\BAAS;

use GuzzleHttp\Promise\PromiseInterface;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Http;
use WeDevBr\Celcoin\Clients\CelcoinBAAS;
use WeDevBr\Celcoin\Tests\GlobalStubs;
use WeDevBr\Celcoin\Tests\TestCase;
use WeDevBr\Celcoin\Types\BAAS\AccountRelease;

class CreateReleaseTest extends TestCase
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
                    sprintf(CelcoinBAAS::CREATE_RELEASE, '300541976902'),
                ) => self::stubSuccess(),
            ],
        );
        $baasWebhook = new CelcoinBAAS();
        $response = $baasWebhook->createRelease(
            '300541976902',
            new AccountRelease([
                'clientCode' => 'f9b978a6-ab7e-4460-997d',
                'amount' => 20,
                'type' => 'CREDIT',
                'description' => 'Deposito',
            ]),
        );

        $this->assertEquals('CONFIRMED', $response['status']);
    }

    private static function stubSuccess(): PromiseInterface
    {
        return Http::response(
            [
                'status' => 'CONFIRMED',
                'version' => '1.0.0',
                'body' => [
                    'id' => '0cdf3a01-71c5-4428-9545-783667ccc289',
                    'clientCode' => 'f9b978a6-ab7e-4460-997d',
                ],
            ],
            Response::HTTP_OK,
        );
    }
}
