<?php

namespace WeDevBr\Celcoin\Tests\Integration\BAAS\PIXKey;

use GuzzleHttp\Promise\PromiseInterface;
use Illuminate\Support\Facades\Http;
use Symfony\Component\HttpFoundation\Response;
use WeDevBr\Celcoin\Clients\CelcoinBAASPIX;
use WeDevBr\Celcoin\Tests\GlobalStubs;
use WeDevBr\Celcoin\Tests\TestCase;

class BAASPIXSearchPixKeyTest extends TestCase
{

    final public function testSuccess(): void
    {
        Http::fake(
            [
                config('celcoin.login_url') => GlobalStubs::loginResponse(),
                sprintf(
                    '%s%s',
                    config('api_url'),
                    sprintf(CelcoinBAASPIX::SEARCH_PIX_KEY_ENDPOINT, '300541976902'),
                ) => self::stubSuccess(),
            ],
        );

        $pix = new CelcoinBAASPIX();
        $response = $pix->searchPixKey('300541976902');

        $this->assertEquals('SUCCESS', $response['status']);
    }

    static private function stubSuccess(): PromiseInterface
    {
        return Http::response(
            [
                "status" => "SUCCESS",
                "body" => [
                    "listKeys" => [
                        0 => [
                            "keyType" => "EVP",
                            "key" => "0a9d3572-eda9-48cb-a8a7-d31d52a82ea7",
                            "account" => [
                                "participant" => "13935893",
                                "branch" => "0001",
                                "account" => "300541976902",
                                "accountType" => "TRAN",
                                "createDate" => "2023-07-19T21:31:59Z",
                            ],
                            "owner" => [
                                "type" => "LEGAL_PERSON",
                                "documentNumber" => "17938715000192",
                                "name" => "Mateus",
                            ],
                        ],
                    ],
                ],
                "version" => "1.0.0",
            ],
            Response::HTTP_OK,
        );
    }
}
