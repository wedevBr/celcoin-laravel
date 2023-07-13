<?php

namespace Tests\Integration\PIX\DYNAMIC;

use GuzzleHttp\Promise\PromiseInterface;
use Illuminate\Http\Client\RequestException;
use Illuminate\Support\Facades\Http;
use Illuminate\Validation\ValidationException;
use Symfony\Component\HttpFoundation\Response;
use Tests\GlobalStubs;
use Tests\TestCase;
use WeDevBr\Celcoin\Clients\CelcoinPIXCOB;
use WeDevBr\Celcoin\Clients\CelcoinPIXDynamic;

class PixDynamicPayloadTest extends TestCase
{
    /**
     * @throws RequestException
     */
    final public function testPixDynamicPayloadSuccess(): void
    {
        $transactionId = 123456;
        $fetchUrl = sprintf('%s%s', config('celcoin.api_url'),
            sprintf(CelcoinPIXCOB::FETCH_COB_PIX_URL, $transactionId)
        );
        Http::fake(
            [
                config('celcoin.login_url') => GlobalStubs::loginResponse(),
                sprintf(
                    '%s?%s',
                    CelcoinPIXDynamic::PAYLOAD_DYNAMIC_QRCODE_ENDPOINT,
                    http_build_query(['url' => $fetchUrl])
                ) => self::stubSuccess(),
            ]
        );

        $pixCOB = new CelcoinPIXDynamic();
        $result = $pixCOB->payload($fetchUrl);
        $this->assertEquals('ATIVA', $result['status']);
        $this->assertEquals(15.01, $result['valor']['original']);
    }

    private static function stubSuccess(): PromiseInterface
    {
        return Http::response(
            [
                'status' => 'ATIVA',
                'infoAdicionais' => NULL,
                'txid' => 'kk6g232xel65a0daee4dd13kk9192148',
                'chave' => 'testepix@celcoin.com.br',
                'solicitacaoPagador' => NULL,
                'valor' => [
                    'original' => '15.01',
                    'abatimento' => NULL,
                    'desconto' => NULL,
                    'multa' => NULL,
                    'juros' => NULL,
                    'final' => NULL,
                    'modalidadeAlteracao' => 0,
                    'retirada' => NULL,
                ],
                'calendario' => [
                    'criacao' => '2022-03-22T14:20:47Z',
                    'expiracao' => 86400,
                    'apresentacao' => '2022-03-22T14:22:24Z',
                    'validadeAposVencimento' => 0,
                ],
                'revisao' => 0,
            ],
            Response::HTTP_OK
        );
    }

    /**
     * @return void
     * @throws RequestException
     */
    final public function testPixDynamicPayloadInvalidUrlParameter(): void
    {
        $transactionId = 123456;
        $fetchUrl = sprintf('%s%s', config('celcoin.api_url'),
            sprintf(CelcoinPIXCOB::FETCH_COB_PIX_URL, $transactionId)
        );
        Http::fake(
            [
                config('celcoin.login_url') => GlobalStubs::loginResponse(),
                sprintf(
                    '%s?%s',
                    CelcoinPIXDynamic::PAYLOAD_DYNAMIC_QRCODE_ENDPOINT,
                    http_build_query(['url' => $fetchUrl])
                ) => self::stubInvalidUrlParameter(),
            ]
        );
        $this->expectException(RequestException::class);
        try {
            $pixCOB = new CelcoinPIXDynamic();
            $pixCOB->payload($fetchUrl);
        } catch (RequestException $exception) {
            $result = $exception->response->json();
            $this->assertEquals('PCE002', $result['errorCode']);
            throw $exception;
        }
    }

    private static function stubInvalidUrlParameter(): PromiseInterface
    {
        return Http::response(
            [
                'message' => 'Invalid url parameter.',
                'errorCode' => 'PCE002',
            ],
            Response::HTTP_BAD_REQUEST
        );
    }

    /**
     * @throws RequestException
     */
    final public function testPixDynamicPayloadInvalidUrl(): void
    {
        $fetchUrl = 'teste';
        Http::fake(
            [
                config('celcoin.login_url') => GlobalStubs::loginResponse(),
                sprintf(
                    '%s?%s',
                    CelcoinPIXDynamic::PAYLOAD_DYNAMIC_QRCODE_ENDPOINT,
                    http_build_query(['url' => $fetchUrl])
                ) => Http::response([], Response::HTTP_BAD_REQUEST),
            ]
        );

        $this->expectException(ValidationException::class);
        try {
            $pixCOB = new CelcoinPIXDynamic();
            $pixCOB->payload($fetchUrl);
        } catch (ValidationException $exception) {
            $errors = $exception->errors();
            $this->assertArrayHasKey('url', $errors);
            throw $exception;
        }
    }
}
