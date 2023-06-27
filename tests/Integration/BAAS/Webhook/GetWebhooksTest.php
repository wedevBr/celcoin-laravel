<?php

namespace Tests\Integration\BAAS\Webhook;

use GuzzleHttp\Promise\PromiseInterface;
use Illuminate\Support\Facades\Http;
use Symfony\Component\HttpFoundation\Response;
use Tests\TestCase;
use WeDevBr\Celcoin\Clients\CelcoinBAASWebhooks;
use WeDevBr\Celcoin\Enums\EntityWebhookBAASEnum;

class GetWebhooksTest extends TestCase
{

    final public function testSuccess(): void
    {
        Http::fake(
            [
                config('celcoin.login_url') => Http::response(
                    [
                        'access_token' => 'fake token',
                        'expires_in' => 2400,
                        'token_type' => 'bearer'
                    ],
                    Response::HTTP_OK
                ),
                sprintf(
                    '%s%s',
                    config('api_url'),
                    CelcoinBAASWebhooks::GET_ENDPOINT
                ) => self::stubSuccess()
            ]
        );

        $webhook = new CelcoinBAASWebhooks();
        $response = $webhook->getWebhook(EntityWebhookBAASEnum::PIX_PAYMENT_OUT, true);

        $this->assertEquals('SUCCESS', $response['status']);
        $this->assertCount(1, $response['body']);
    }

    static private function stubSuccess(): PromiseInterface
    {
        return Http::response(
            [
                "version" => "1.0.0",
                "status" => "SUCCESS",
                "body" => [
                    "entity" => "string",
                    "webhookUrl" => "string",
                    "active" => true,
                    "createDate" => "2023-03-06T12:02:48.419Z",
                    "lastUpdateDate" => "2023-03-06T12:02:48.419Z",
                    "auth" => [
                        "login" => "string",
                        "pwd" => "string",
                        "type" => "string"
                    ]
                ]
            ],
            Response::HTTP_OK
        );
    }
}
