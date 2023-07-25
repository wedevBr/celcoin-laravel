<?php

namespace Tests\Integration\PIX\Webhooks;

use Closure;
use GuzzleHttp\Promise\PromiseInterface;
use Illuminate\Http\Client\RequestException;
use Illuminate\Support\Facades\Http;
use Symfony\Component\HttpFoundation\Response;
use Tests\GlobalStubs;
use Tests\TestCase;
use WeDevBr\Celcoin\Clients as Clients;
use WeDevBr\Celcoin\Enums\WebhookEventEnum;
use WeDevBr\Celcoin\Types\PIX as Types;

class PixReactivateEventAndResendSpecifiedMessagesInListTest extends TestCase
{
    use GenericWebhookErrorsTrait;

    /**
     * @throws RequestException
     */
    final public function testWebhookGetListSuccess(): void
    {
        /**
         * @var Types\PixReactivateEventAndResendSpecifiedMessagesInList $params
         * @var WebhookEventEnum $webhookEventEnum
         */
        [$params, $webhookEventEnum] = $this->callWebhookBase(fn() => self::stubSuccess());

        $pix = new Clients\CelcoinPixWebhooks();
        $response = $pix->reactivateEventAndResendSpecifiedMessagesInList($webhookEventEnum, $params);
        $this->assertEquals('200', $response['status']);
    }

    /**
     * @param Closure<PromiseInterface> $stub
     * @param WebhookEventEnum $webhookEventEnum
     * @return array<Types\PixReactivateEventAndResendSpecifiedMessagesInList, WebhookEventEnum>
     */
    private function callWebhookBase(Closure $stub, WebhookEventEnum $webhookEventEnum = WebhookEventEnum::CONFIRMED): array
    {
        $params = new Types\PixReactivateEventAndResendSpecifiedMessagesInList();

        $url = sprintf(Clients\CelcoinPixWebhooks::RESEND_TRANSACTION_LIST_WEBHOOK, $webhookEventEnum->value);

        Http::fake(
            [
                config('celcoin.login_url') => GlobalStubs::loginResponse(),
                sprintf(
                    '%s%s',
                    config('api_url'),
                    $url
                ) => $stub
            ]
        );
        return [$params, $webhookEventEnum];
    }

    private static function stubSuccess(): PromiseInterface
    {
        return Http::response(
            [
                'version' => 'v1.0',
                'webhookEvent' => 'CONFIRMED',
                'dateTo' => '2023-07-22T00:00:00+00:00',
                'dateFrom' => '2023-07-21T00:00:00+00:00',
                'status' => 200,
            ],
            Response::HTTP_OK
        );
    }

    /**
     * @throws RequestException
     * @dataProvider notFoundErrorProvider
     */
    final public function testWebhookErrorNotFound(string $returnCode, Closure $stub): void
    {
        /**
         * @var Types\PixReactivateEventAndResendSpecifiedMessagesInList $params
         * @var WebhookEventEnum $webhookEventEnum
         */
        [$params, $webhookEventEnum] = $this->callWebhookBase($stub);

        $this->expectException(RequestException::class);
        try {
            $pix = new Clients\CelcoinPixWebhooks();
            $pix->reactivateEventAndResendSpecifiedMessagesInList($webhookEventEnum, $params);
        } catch (RequestException $exception) {
            $response = $exception->response->json();
            $this->assertEquals($returnCode, $response['error']['errorCode']);
            throw $exception;
        }
    }
}