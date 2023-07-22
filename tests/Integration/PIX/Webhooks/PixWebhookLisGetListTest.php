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

class PixWebhookLisGetListTest extends TestCase
{
    /**
     * @throws RequestException
     */
    final public function testWebhookGetListSuccess(): void
    {
        /**
         * @var Types\PixWebhookGetList $params
         * @var WebhookEventEnum $webhookEventEnum
         */
        [$params, $webhookEventEnum] = $this->callWebhookBase(fn() => self::stubSuccess());

        $pix = new Clients\CelcoinPixWebhooks();
        $response = $pix->getList($webhookEventEnum, $params);
        $this->assertEquals('200', $response['status']);
    }

    /**
     * @param Closure<PromiseInterface> $stub
     * @return array<Types\PixWebhookGetList, WebhookEventEnum>
     */
    private function callWebhookBase(Closure $stub): array
    {
        $params = new Types\PixWebhookGetList();

        $webhookEventEnum = WebhookEventEnum::ERROR;
        $url = sprintf(Clients\CelcoinPixWebhooks::PIX_WEBHOOK_GET_LIST_ENDPOINT, $webhookEventEnum->value);

        if (sizeof($params->toArray()) > 1) {
            $url .= '?' . http_build_query($params->toArray());
        }

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
                'webhookEvent' => 'CONFIRMED',
                'dateTo' => '2023-07-22T00:00:00+00:00',
                'dateFrom' => '2023-07-21T00:00:00+00:00',
                'totalFound' => 0,
                'totalReturned' => 0,
                'status' => 200,
            ],
            Response::HTTP_OK
        );
    }

    final public function notFoundErrorProvider(): array
    {
        return [
            'Webhook required' => [
                'WEBHMVAL01',
                fn() => self::stubErrorWebhookRequiredNotFound(),
            ],
            'Invalid Webhook' => [
                'WEBHMVAL02',
                fn() => self::stubInvalidWebhookError(),
            ],
            'DateFrom cannot be greater than dateTo' => [
                'WEBHMVAL03',
                fn() => self::stubDateFromCannotBeGreaterThanDateToError(),
            ],
            'Invalid date interval' => [
                'WEBHMVAL04',
                fn() => self::stubInvalidDateIntervalError(),
            ],
            'Invalid dateFrom' => [
                'WEBHMVAL05',
                fn() => self::stubInvalidDateFromError(),
            ],
            'Invalid dateTo' => [
                'WEBHMVAL06',
                fn() => self::stubInvalidDateToError(),
            ],
            'Limit field value should not exceed 100' => [
                'WEBHMVAL08',
                fn() => self::stubErrorLimitFieldValueShouldNotExceed100(),
            ],
            'Cannot resend already sent webhook' => [
                'WEBHMVAL09',
                fn() => self::stubErrorCannotResendAlreadySentWebhook(),
            ]


        ];
    }

    private static function stubErrorWebhookRequiredNotFound(): PromiseInterface
    {
        return Http::response(
            [
                'version' => 'v1.0',
                'status' => 400,
                'error' => [
                    'errorCode' => 'WEBHMVAL01',
                    'message' => 'O webhookEvento é Obrigatório',
                ],
            ],
            Response::HTTP_NOT_FOUND
        );
    }

    private static function stubInvalidWebhookError(): PromiseInterface
    {
        return Http::response(
            [
                'version' => 'v1.0',
                'status' => 400,
                'error' => [
                    'errorCode' => 'WEBHMVAL02',
                    'message' => 'webhookEvento Inválido',
                ],
            ], Response::HTTP_NOT_FOUND
        );
    }

    private static function stubDateFromCannotBeGreaterThanDateToError(): PromiseInterface
    {
        return Http::response(
            [
                'version' => 'v1.0',
                'status' => 400,
                'error' => [
                    'errorCode' => 'WEBHMVAL03',
                    'message' => 'dateFrom não pode ser maior que o dateTo',
                ],
            ], Response::HTTP_NOT_FOUND
        );
    }

    private static function stubInvalidDateIntervalError(): PromiseInterface
    {
        return Http::response(
            [
                'version' => 'v1.0',
                'status' => 400,
                'error' => [
                    'errorCode' => 'WEBHMVAL04',
                    'message' => 'O intervalo entre as datas não pode ser superior a 1 dia',
                ],
            ], Response::HTTP_NOT_FOUND
        );
    }

    private static function stubInvalidDateFromError(): PromiseInterface
    {
        return Http::response(
            [
                'version' => 'v1.0',
                'status' => 400,
                'error' => [
                    'errorCode' => 'WEBHMVAL05',
                    'message' => 'dateFrom inválido',
                ],
            ], Response::HTTP_NOT_FOUND
        );
    }

    private static function stubInvalidDateToError(): PromiseInterface
    {
        return Http::response(
            [
                'version' => 'v1.0',
                'status' => 400,
                'error' => [
                    'errorCode' => 'WEBHMVAL06',
                    'message' => 'dateTo inválido',
                ],
            ],
            Response::HTTP_NOT_FOUND
        );
    }

    private static function stubErrorLimitFieldValueShouldNotExceed100(): PromiseInterface
    {
        return Http::response(
            [
                'version' => 'v1.0',
                'status' => 400,
                'error' => [
                    'errorCode' => 'WEBHMVAL08',
                    'message' => 'O campo limit não deve ultrapassar o valor de 100',
                ],
            ],
            Response::HTTP_NOT_FOUND
        );
    }

    private static function stubErrorCannotResendAlreadySentWebhook(): PromiseInterface
    {
        return Http::response(
            [
                'version' => 'v1.0',
                'status' => 400,
                'error' => [
                    'errorCode' => 'WEBHMVAL09',
                    'message' => 'Não é possivel reenviar um webhook já enviado',
                ],
            ],
            Response::HTTP_NOT_FOUND
        );
    }

    /**
     * @throws RequestException
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