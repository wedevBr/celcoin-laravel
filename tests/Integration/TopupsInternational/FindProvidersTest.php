<?php

namespace Tests\Integration\BillPayments;

use GuzzleHttp\Promise\PromiseInterface;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Http;
use Tests\GlobalStubs;
use Tests\TestCase;
use WeDevBr\Celcoin\Clients\CelcoinTopups;
use WeDevBr\Celcoin\Enums\TopupProvidersCategoryEnum;
use WeDevBr\Celcoin\Enums\TopupProvidersTypeEnum;
use WeDevBr\Celcoin\Types\Topups\Providers;

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
                    CelcoinTopups::FIND_PROVIDERS_ENDPOINT
                ) => self::stubSuccess()
            ]
        );

        $payment = new CelcoinTopups();
        $response = $payment->findProviders(13, 912345678);
        $this->assertEquals(0, $response['status']);
    }

    static private function stubSuccess(): PromiseInterface
    {
        return Http::response(
            [
                "nameProvider" => "Claro",
                "providerId" => 2087,
                "errorCode" => "000",
                "message" => "SUCESSO",
                "status" => 0
            ],
            Response::HTTP_OK
        );
    }
}
