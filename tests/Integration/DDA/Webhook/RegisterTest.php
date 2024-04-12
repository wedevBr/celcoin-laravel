<?php

namespace WeDevBr\Celcoin\Tests\Integration\DDA\Webhook;

use GuzzleHttp\Promise\PromiseInterface;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Http;
use WeDevBr\Celcoin\Clients\CelcoinDDAWebhooks;
use WeDevBr\Celcoin\Enums\DDAWebhooksTypeEventEnum;
use WeDevBr\Celcoin\Tests\GlobalStubs;
use WeDevBr\Celcoin\Tests\TestCase;
use WeDevBr\Celcoin\Types\DDA\RegisterWebhooks;

class RegisterTest extends TestCase
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
                    CelcoinDDAWebhooks::REGISTER_ENDPOINT,
                ) => self::stubSuccess(),
            ],
        );

        $dda = new CelcoinDDAWebhooks();
        $response = $dda->register(
            new RegisterWebhooks([
                'typeEventWebhook' => DDAWebhooksTypeEventEnum::INVOICE,
                'url' => 'https://webhook.site/d24aa98f-1837-4698-8825-688f94390cfe',
                'basicAuthentication' => [
                    'identification' => 'João',
                    'password' => 'Um@Pro7ec@o',
                ],
            ]),
        );

        $this->assertEquals(201, $response['status']);
    }

    private static function stubSuccess(): PromiseInterface
    {
        return Http::response(
            [
                'status' => 201,
                'body' => [
                    'typeEventWebhook' => 'Invoice',
                    'url' => 'https://webhook.site/d24aa98f-1837-4698-8825-688f94390cfe',
                    'basicAuthentication' => [
                        'identification' => 'João',
                        'password' => 'Um@Pro7ec@o',
                    ],
                    'oAuthTwo' => null,
                ],
            ],
            Response::HTTP_OK,
        );
    }
}
