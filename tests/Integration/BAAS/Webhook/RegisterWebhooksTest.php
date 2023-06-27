<?php

namespace Tests\Integration\BAAS\Webhook;

use GuzzleHttp\Promise\PromiseInterface;
use Illuminate\Support\Facades\Http;
use Symfony\Component\HttpFoundation\Response;
use Tests\TestCase;
use WeDevBr\Celcoin\Clients\CelcoinBAASWebhooks;
use WeDevBr\Celcoin\Types\BAAS\RegisterWebhooks;

class RegisterWebhooksTest extends TestCase
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
                    CelcoinBAASWebhooks::REGISTER_ENDPOINT
                ) => self::stubSuccess()
            ]
        );

        $webhook = new CelcoinBAASWebhooks();
        $response = $webhook->register(new RegisterWebhooks([
            "entity" => "pix-payment-out",
            "webhookUrl" => "https://www.celcoin.com.br/baas",
            "auth" => [
                "login" => "string",
                "pwd" => "string",
                "type" => "basic"
            ],
            "active" => false
        ]));

        $this->assertEquals('SUCCESS', $response['status']);
    }

    static private function stubSuccess(): PromiseInterface
    {
        return Http::response(
            [
                "version" => "1.0.0",
                "status" => "SUCCESS"
            ],
            Response::HTTP_OK
        );
    }
}
