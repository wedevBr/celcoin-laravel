<?php

namespace Tests\Integration\BAAS\PixCashOut;

use GuzzleHttp\Promise\PromiseInterface;
use Illuminate\Support\Facades\Http;
use Symfony\Component\HttpFoundation\Response;
use Tests\GlobalStubs;
use Tests\TestCase;
use WeDevBr\Celcoin\Clients\CelcoinBAASPIX;

class BAASPIXGetExternalPixKeyTest extends TestCase
{

    final public function testSuccess(): void
    {
        Http::fake(
            [
                config('celcoin.login_url') => GlobalStubs::loginResponse(),
                sprintf(
                    '%s%s*',
                    config('api_url'),
                    sprintf(CelcoinBAASPIX::GET_EXTERNAL_KEY_ENDPOINT, '')
                ) => self::stubSuccess()
            ]
        );

        $pix = new CelcoinBAASPIX();
        $response = $pix->getExternalPixKey('300541976910', '0a9d3572-eda9-48cb-a8a7-d31d52a82ea7');

        $this->assertEquals('SUCCESS', $response['status']);
    }

    static private function stubSuccess(): PromiseInterface
    {
        return Http::response(
            [
                "status" => "SUCCESS",
                "body" => [
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
                    "endtoEndId" => "E1393589320230719213601039975372",
                ],
                "version" => "1.0.0",
            ],
            Response::HTTP_OK
        );
    }
}
