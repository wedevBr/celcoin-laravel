<?php

namespace WeDevBr\Celcoin\Tests\Integration\BAAS\Webhook;

use GuzzleHttp\Promise\PromiseInterface;
use Illuminate\Support\Facades\Http;
use Symfony\Component\HttpFoundation\Response;
use WeDevBr\Celcoin\Clients\CelcoinBAASWebhooks;
use WeDevBr\Celcoin\Enums\EntityWebhookBAASEnum;
use WeDevBr\Celcoin\Tests\GlobalStubs;
use WeDevBr\Celcoin\Tests\TestCase;

class GetWebhooksTest extends TestCase
{
    final public function testSuccess(): void
    {
        Http::fake(
            [
                config('celcoin.login_url') => GlobalStubs::loginResponse(),
                sprintf(
                    '%s%s*',
                    config('api_url'),
                    CelcoinBAASWebhooks::GET_ENDPOINT,
                ) => self::stubSuccess(),
            ],
        );

        $webhook = new CelcoinBAASWebhooks();
        $response = $webhook->getWebhook(EntityWebhookBAASEnum::SPB_TRANSFER_OUT_TED, false);

        $this->assertEquals('SUCCESS', $response['status']);
    }

    private static function stubSuccess(): PromiseInterface
    {
        return Http::response(
            [
                'body' => [
                    'subscriptions' => [
                        0 => [
                            'subscriptionId' => '64b13326a90a5b4a702dac3f',
                            'entity' => 'pix-payment-out',
                            'webhookUrl' => 'http://uoleti.io/transaction/webhook/LEKMZqMJUjBaVen1kyb9',
                            'active' => true,
                            'createDate' => '2023-07-14T08:36:06.292Z',
                            'lastUpdateDate' => null,
                            'auth' => null,
                        ],
                    ],
                ],
                'status' => 'SUCCESS',
                'version' => '1.0.0',
            ],
            Response::HTTP_OK,
        );
    }
}
