<?php

namespace Tests\Integration\DDA\Webhook;

use GuzzleHttp\Promise\PromiseInterface;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Http;
use Tests\GlobalStubs;
use Tests\TestCase;
use WeDevBr\Celcoin\Clients\CelcoinDDAWebhooks;

class ListTest extends TestCase
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
                    CelcoinDDAWebhooks::LIST_ENDPOINT
                ) => self::stubSuccess()
            ]
        );

        $dda = new CelcoinDDAWebhooks();
        $response = $dda->list();

        $this->assertEquals(200, $response['status']);
    }

    static private function stubSuccess(): PromiseInterface
    {
        return Http::response(
            [
                "status" => 200,
                "body" => [
                    [
                        "typeEventWebhook" => "Invoice",
                        "url" => "https://webhook.site/adf0d812-3e2d-43cc-91be-3d84128d27ab"
                    ],
                    [
                        "typeEventWebhook" => "Deletion",
                        "url" => "https://webhook.site/adf0d812-3e2d-43cc-91be-3d84128d27ab"
                    ],
                    [
                        "typeEventWebhook" => "Subscription",
                        "url" => "https://webhook.site/adf0d812-3e2d-43cc-91be-3d84128d27ab"
                    ]
                ]
            ],
            Response::HTTP_OK
        );
    }
}
