<?php

namespace WeDevBr\Celcoin\Tests\Integration\PIX\Webhooks;

use GuzzleHttp\Promise\PromiseInterface;
use Illuminate\Support\Facades\Http;
use Symfony\Component\HttpFoundation\Response;

trait GenericWebhookErrorsTrait
{
    public static function stubErrorWebhookRequiredNotFound(): PromiseInterface
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
            Response::HTTP_NOT_FOUND,
        );
    }

    public static function stubInvalidWebhookError(): PromiseInterface
    {
        return Http::response(
            [
                'version' => 'v1.0',
                'status' => 400,
                'error' => [
                    'errorCode' => 'WEBHMVAL02',
                    'message' => 'webhookEvento Inválido',
                ],
            ],
            Response::HTTP_NOT_FOUND,
        );
    }

    public static function stubDateFromCannotBeGreaterThanDateToError(): PromiseInterface
    {
        return Http::response(
            [
                'version' => 'v1.0',
                'status' => 400,
                'error' => [
                    'errorCode' => 'WEBHMVAL03',
                    'message' => 'dateFrom não pode ser maior que o dateTo',
                ],
            ],
            Response::HTTP_NOT_FOUND,
        );
    }

    public static function stubInvalidDateIntervalError(): PromiseInterface
    {
        return Http::response(
            [
                'version' => 'v1.0',
                'status' => 400,
                'error' => [
                    'errorCode' => 'WEBHMVAL04',
                    'message' => 'O intervalo entre as datas não pode ser superior a 1 dia',
                ],
            ],
            Response::HTTP_NOT_FOUND,
        );
    }

    public static function stubInvalidDateFromError(): PromiseInterface
    {
        return Http::response(
            [
                'version' => 'v1.0',
                'status' => 400,
                'error' => [
                    'errorCode' => 'WEBHMVAL05',
                    'message' => 'dateFrom inválido',
                ],
            ],
            Response::HTTP_NOT_FOUND,
        );
    }

    public static function stubInvalidDateToError(): PromiseInterface
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
            Response::HTTP_NOT_FOUND,
        );
    }

    public static function stubErrorLimitFieldValueShouldNotExceed100(): PromiseInterface
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
            Response::HTTP_NOT_FOUND,
        );
    }

    public static function stubErrorCannotResendAlreadySentWebhook(): PromiseInterface
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
            Response::HTTP_NOT_FOUND,
        );
    }

    final public static function notFoundErrorProvider(): array
    {
        return [
            'Webhook required' => [
                'WEBHMVAL01',
                fn () => self::stubErrorWebhookRequiredNotFound(),
            ],
            'Invalid Webhook' => [
                'WEBHMVAL02',
                fn () => self::stubInvalidWebhookError(),
            ],
            'DateFrom cannot be greater than dateTo' => [
                'WEBHMVAL03',
                fn () => self::stubDateFromCannotBeGreaterThanDateToError(),
            ],
            'Invalid date interval' => [
                'WEBHMVAL04',
                fn () => self::stubInvalidDateIntervalError(),
            ],
            'Invalid dateFrom' => [
                'WEBHMVAL05',
                fn () => self::stubInvalidDateFromError(),
            ],
            'Invalid dateTo' => [
                'WEBHMVAL06',
                fn () => self::stubInvalidDateToError(),
            ],
            'Limit field value should not exceed 100' => [
                'WEBHMVAL08',
                fn () => self::stubErrorLimitFieldValueShouldNotExceed100(),
            ],
            'Cannot resend already sent webhook' => [
                'WEBHMVAL09',
                fn () => self::stubErrorCannotResendAlreadySentWebhook(),
            ],

        ];
    }
}
