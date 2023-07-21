<?php

namespace Tests\Integration\BAAS\Webhook;

use GuzzleHttp\Promise\PromiseInterface;
use Illuminate\Support\Facades\Http;
use Symfony\Component\HttpFoundation\Response;
use Tests\GlobalStubs;
use Tests\TestCase;
use WeDevBr\Celcoin\Clients\CelcoinBAASWebhooks;
use WeDevBr\Celcoin\Enums\EntityWebhookBAASEnum;
use WeDevBr\Celcoin\Types\BAAS\EditWebhooks;

class EditWebhooksTest extends TestCase
{

    final public function testSuccess(): void
    {
        Http::fake(
            [
                config('celcoin.login_url') => GlobalStubs::loginResponse(),
                sprintf(
                    '%s%s',
                    config('api_url'),
                    sprintf(CelcoinBAASWebhooks::EDIT_ENDPOINT, EntityWebhookBAASEnum::PIX_PAYMENT_IN->value)
                ) => self::stubSuccess()
            ]
        );

        $webhook = new CelcoinBAASWebhooks();
        $response = $webhook->edit(new EditWebhooks([
            "entity" => EntityWebhookBAASEnum::SPB_REVERSAL_OUT_TED,
            "webhookUrl" => "https://www.celcoin.com.br/baas",
            "auth" => [
                "login" => "giovanni",
                "pwd" => "string",
                "type" => "basic"
            ],
            "active" => true
        ]), EntityWebhookBAASEnum::SPB_TRANSFER_OUT_TED);

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
