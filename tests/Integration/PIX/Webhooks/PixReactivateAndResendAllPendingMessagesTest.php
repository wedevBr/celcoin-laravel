<?php

namespace WeDevBr\Celcoin\Tests\Integration\PIX\Webhooks;

use Closure;
use GuzzleHttp\Promise\PromiseInterface;
use Illuminate\Http\Client\RequestException;
use Illuminate\Support\Facades\Http;
use Symfony\Component\HttpFoundation\Response;
use WeDevBr\Celcoin\Clients as Clients;
use WeDevBr\Celcoin\Enums\WebhookEventEnum;
use WeDevBr\Celcoin\Tests\GlobalStubs;
use WeDevBr\Celcoin\Tests\TestCase;
use WeDevBr\Celcoin\Types\PIX as Types;

class PixReactivateAndResendAllPendingMessagesTest extends TestCase
{
    use GenericWebhookErrorsTrait;

    /**
     * @throws RequestException
     */
    final public function testWebhookGetListSuccess(): void
    {
        /**
         * @var Types\PixReactivateAndResendAllPendingMessages $params
         * @var WebhookEventEnum $webhookEventEnum
         */
        [$params, $webhookEventEnum] = $this->callWebhookBase(fn() => self::stubSuccess());

        $pix = new Clients\CelcoinPixWebhooks();
        $response = $pix->reactivateAndResendAllPendingMessages($webhookEventEnum, $params);
        $this->assertEquals('200', $response['status']);
    }

    /**
     * @param Closure<PromiseInterface> $stub
     * @param WebhookEventEnum $webhookEventEnum
     *
     * @return array<Types\PixReactivateAndResendAllPendingMessages, WebhookEventEnum>
     */
    private function callWebhookBase(
        Closure $stub,
        WebhookEventEnum $webhookEventEnum = WebhookEventEnum::CONFIRMED,
    ): array {
        $params = new Types\PixReactivateAndResendAllPendingMessages();

        $url = sprintf(Clients\CelcoinPixWebhooks::PIX_REACTIVATE_RESEND_PENDING_ENDPOINT, $webhookEventEnum->value);

        if (sizeof($params->toArray()) > 1) {
            $url .= '?' . http_build_query($params->toArray());
        }

        Http::fake(
            [
                config('celcoin.login_url') => GlobalStubs::loginResponse(),
                sprintf(
                    '%s%s',
                    config('api_url'),
                    $url,
                ) => $stub,
            ],
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
            Response::HTTP_OK,
        );
    }

    /**
     * @throws RequestException
     * @dataProvider notFoundErrorProvider
     */
    final public function testWebhookErrorNotFound(string $returnCode, Closure $stub): void
    {
        /**
         * @var Types\PixReactivateAndResendAllPendingMessages $params
         * @var WebhookEventEnum $webhookEventEnum
         */
        [$params, $webhookEventEnum] = $this->callWebhookBase($stub);

        $this->expectException(RequestException::class);
        try {
            $pix = new Clients\CelcoinPixWebhooks();
            $pix->reactivateAndResendAllPendingMessages($webhookEventEnum, $params);
        } catch (RequestException $exception) {
            $response = $exception->response->json();
            $this->assertEquals($returnCode, $response['error']['errorCode']);
            throw $exception;
        }
    }
}