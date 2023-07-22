<?php

namespace Tests\Integration\PIX\Reverse;


use Closure;
use GuzzleHttp\Promise\PromiseInterface;
use Illuminate\Http\Client\RequestException;
use Illuminate\Support\Facades\Http;
use Symfony\Component\HttpFoundation\Response;
use Tests\GlobalStubs;
use Tests\TestCase;
use WeDevBr\Celcoin\Clients as Clients;
use WeDevBr\Celcoin\Types\PIX as Types;

class PixReverseGetStatusTest extends TestCase
{

    final public function notFoundErrorProvider(): array
    {
        return [
            'Original transaction not found' => ['11', fn() => self::stubErrorOriginalTransactionNotFound()],
            'Transaction exceeded' => ['12', fn() => self::stubErrorTransactionExceededNotFound()],
            'Receivement transaction not found' => ['99', fn() => self::stubErrorReceivementTransactionNotFound()],
            'Uncatchable error not found' => ['999', fn() => self::stubUnwatchableErrorNotFound()],
            'Insufficient funds' => ['40', fn() => self::stubInsufficientFunds()],
        ];
    }

    private static function stubErrorOriginalTransactionNotFound(): PromiseInterface
    {
        return Http::response(
            [
                'code' => '11',
                'description' => 'Transação original não encontrada.',
            ],
            Response::HTTP_NOT_FOUND
        );
    }

    private static function stubErrorTransactionExceededNotFound(): PromiseInterface
    {
        return Http::response(
            [
                'code' => '12',
                'description' => 'Limite de devolução excedido para a transação original.',
            ],
            Response::HTTP_NOT_FOUND
        );
    }

    private static function stubErrorReceivementTransactionNotFound(): PromiseInterface
    {
        return Http::response(
            [
                'code' => '99',
                'description' => 'Transação de recebimento não encontrada.',
            ],
            Response::HTTP_NOT_FOUND
        );
    }

    private static function stubUnwatchableErrorNotFound(): PromiseInterface
    {
        return Http::response(
            [
                'code' => '999',
                'description' => 'Erro desconhecido no account service..',
            ],
            Response::HTTP_NOT_FOUND
        );
    }

    private static function stubInsufficientFunds(): PromiseInterface
    {
        return Http::response(
            [
                'code' => '40',
                'description' => 'Saldo insuficiente',
            ],
            Response::HTTP_NOT_FOUND
        );
    }

    /**
     * @throws RequestException
     */
    final public function testReverseGetStatusSuccess(): void
    {
        $params = new Types\PixReverseGetStatus();
        $params->clientCode = '123456';

        $url = sprintf(
            '%s?%s',
            Clients\CelcoinPIXReverse::PIX_REVERSE_GET_STATUS_ENDPOINT,
            http_build_query($params->toArray())
        );
        Http::fake(
            [
                config('celcoin.login_url') => GlobalStubs::loginResponse(),
                sprintf(
                    '%s%s',
                    config('api_url'),
                    $url
                ) => self::stubSuccess()
            ]
        );

        $pix = new Clients\CelcoinPIXReverse();
        $response = $pix->getStatus($params);
        $this->assertEquals('ERROR', $response['status']);
    }

    private static function stubSuccess(): PromiseInterface
    {
        return Http::response(
            [
                'status' => 'ERROR',
                'returnIdentification' => 'E22896455202211101038nbxkcXYX',
                'additionalInformation' => 'ABCD',
                'clientCode' => '123',
                'originalEndToEndId' => 'E22896431203344101038nbxkcXYZ',
                'transactionId' => 123,
                'amount' => 10,
                'reason' => 'BE08',
                'error' => [
                    'code' => 'PBE150',
                    'description' => 'General reject operation.',
                ],
            ],
            Response::HTTP_OK
        );
    }

    /**
     * @throws RequestException
     * @dataProvider notFoundErrorProvider
     */
    final public function testReverseGetStatusErrorNotFound(string $returnCode, Closure $stub): void
    {
        $params = new Types\PixReverseGetStatus();
        $params->clientCode = '123456';

        $url = sprintf(
            '%s?%s',
            Clients\CelcoinPIXReverse::PIX_REVERSE_GET_STATUS_ENDPOINT,
            http_build_query($params->toArray())
        );
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

        $this->expectException(RequestException::class);
        try {
            $pix = new Clients\CelcoinPIXReverse();
            $pix->getStatus($params);
        } catch (RequestException $exception) {
            $response = $exception->response->json();
            $this->assertEquals($returnCode, $response['code']);
            throw $exception;
        }
    }
}
