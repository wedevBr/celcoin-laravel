<?php

namespace WeDevBr\Celcoin\Tests\Integration\BAAS\Webhook;

use GuzzleHttp\Promise\PromiseInterface;
use Illuminate\Support\Facades\Http;
use Symfony\Component\HttpFoundation\Response;
use WeDevBr\Celcoin\Clients\CelcoinBAASWebhooks;
use WeDevBr\Celcoin\Enums\EntityWebhookBAASEnum;
use WeDevBr\Celcoin\Tests\GlobalStubs;
use WeDevBr\Celcoin\Tests\TestCase;
use WeDevBr\Celcoin\Types\BAAS\RegisterWebhooks;

class RegisterWebhooksTest extends TestCase
{

    final public function testSuccess(): void
    {
        Http::fake(
            [
                config('celcoin.login_url') => GlobalStubs::loginResponse(),
                sprintf(
                    '%s%s',
                    config('api_url'),
                    CelcoinBAASWebhooks::REGISTER_ENDPOINT,
                ) => self::stubSuccess(),
            ],
        );

        $webhook = new CelcoinBAASWebhooks();
        $response = $webhook->register(
            new RegisterWebhooks([
                "entity" => EntityWebhookBAASEnum::SPB_TRANSFER_OUT_TED,
                "webhookUrl" => "https://www.celcoin.com.br/baas",
                "auth" => [
                    "login" => "string",
                    "pwd" => "string",
                    "type" => "basic",
                ],
            ]),
        );

        $this->assertEquals('SUCCESS', $response['status']);
    }

    static private function stubSuccess(): PromiseInterface
    {
        return Http::response(
            [
                "body" => [
                    "subscriptionId" => "64bb0bef9065331bad7bf996",
                ],
                "version" => "1.0.0",
                "status" => "SUCCESS",
            ],
            Response::HTTP_OK,
        );
    }
}
