<?php

namespace Tests\Integration\BAAS\Webhook;

use GuzzleHttp\Promise\PromiseInterface;
use Illuminate\Support\Facades\Http;
use Symfony\Component\HttpFoundation\Response;
use Tests\GlobalStubs;
use Tests\TestCase;
use WeDevBr\Celcoin\Clients\CelcoinBAASWebhooks;
use WeDevBr\Celcoin\Enums\EntityWebhookBAASEnum;

class RemoveWebhooksTest extends TestCase
{

    final public function testSuccess(): void
    {
        Http::fake(
            [
                config('celcoin.login_url') => GlobalStubs::loginResponse(),
                sprintf(
                    '%s%s',
                    config('api_url'),
                    sprintf(CelcoinBAASWebhooks::REMOVE_ENDPOINT, EntityWebhookBAASEnum::PIX_PAYMENT_OUT->value)
                ) => self::stubSuccess()
            ]
        );

        $webhook = new CelcoinBAASWebhooks();
        $response = $webhook->remove(EntityWebhookBAASEnum::PIX_PAYMENT_OUT);

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
