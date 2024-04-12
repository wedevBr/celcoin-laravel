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

class PixWebhookLisGetListTest extends TestCase
{
    use GenericWebhookErrorsTrait;

    /**
     * @throws RequestException
     */
    final public function testWebhookGetListSuccess(): void
    {
        /**
         * @var Types\PixWebhookGetList $params
         * @var WebhookEventEnum $webhookEventEnum
         */
        [$params, $webhookEventEnum] = $this->callWebhookBase(fn () => self::stubSuccess());

        $pix = new Clients\CelcoinPixWebhooks();
        $response = $pix->getList($webhookEventEnum, $params);
        $this->assertEquals('200', $response['status']);
    }

    /**
     * @param  Closure<PromiseInterface>  $stub
     * @return array<Types\PixWebhookGetList, WebhookEventEnum>
     */
    private function callWebhookBase(Closure $stub): array
    {
        $params = new Types\PixWebhookGetList();

        $webhookEventEnum = WebhookEventEnum::ERROR;
        $url = sprintf(Clients\CelcoinPixWebhooks::PIX_WEBHOOK_GET_LIST_ENDPOINT, $webhookEventEnum->value);

        if (count($params->toArray()) > 1) {
            $url .= '?'.http_build_query($params->toArray());
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
                'status' => 200,
                'webhookEvent' => 'ERROR',
                'dateTo' => '2022-09-20',
                'dateFrom' => '2022-09-21',
                'totalFound' => 0,
                'totalReturned' => 0,
                'eventStatus' => 'Bloqueado',
                'webhookDetails' => [
                    [
                        'endpoint' => 'www.api.com.br/teste',
                        'status' => 'Bloqueado)',
                        'transactionId' => 12312331,
                        'dateLastUpdate' => '2022-09-21',
                        'requestBody' => '{"RequestBody":{"TransactionType":"PAYMENT","TransactionId":4644372,"StatusCode":{"StatusId":2,"Description":"Confirmed"}}}',
                        'statusCode' => '200',
                    ],
                ],
            ],
            Response::HTTP_OK,
        );
    }

    /**
     * @throws RequestException
     *
     * @dataProvider notFoundErrorProvider
     */
    final public function testWebhookErrorNotFound(string $returnCode, Closure $stub): void
    {
        /**
         * @var Types\PixWebhookGetList $params
         * @var WebhookEventEnum $webhookEventEnum
         */
        [$params, $webhookEventEnum] = $this->callWebhookBase($stub);

        $this->expectException(RequestException::class);
        try {
            $pix = new Clients\CelcoinPixWebhooks();
            $pix->getList($webhookEventEnum, $params);
        } catch (RequestException $exception) {
            $response = $exception->response->json();
            $this->assertEquals($returnCode, $response['error']['errorCode']);
            throw $exception;
        }
    }
}
