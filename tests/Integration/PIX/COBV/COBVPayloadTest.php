<?php

namespace WeDevBr\Celcoin\Tests\Integration\PIX\COBV;

use GuzzleHttp\Promise\PromiseInterface;
use Illuminate\Http\Client\RequestException;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Str;
use Illuminate\Validation\ValidationException;
use Symfony\Component\HttpFoundation\Response;
use WeDevBr\Celcoin\Clients\CelcoinPIXCOBV;
use WeDevBr\Celcoin\Tests\GlobalStubs;
use WeDevBr\Celcoin\Tests\TestCase;

class COBVPayloadTest extends TestCase
{
    /**
     * @throws RequestException
     */
    final public function testPayloadCobvSuccess(): void
    {
        $transactionId = 123456;
        $fetchUrl = sprintf(
            '%s%s',
            config('celcoin.api_url'),
            sprintf(
                '%s?%s',
                CelcoinPIXCOBV::GET_COBV_PIX,
                http_build_query(compact('transactionId')),
            ),
        );
        Http::fake(
            [
                config('celcoin.login_url') => GlobalStubs::loginResponse(),
                config('celcoin.api_url') . sprintf(CelcoinPIXCOBV::PAYLOAD_COBV_PIX, urlencode(Str::replace('https://', '', $fetchUrl))) => self::stubSuccess(),
            ],
        );

        $pixCOB = new CelcoinPIXCOBV();
        $result = $pixCOB->payloadCOBVPIX($fetchUrl);
        $this->assertArrayHasKey('calendar', $result);
        $this->assertArrayHasKey('debtor', $result);
        $this->assertArrayHasKey('receiver', $result);
        $this->assertArrayHasKey('status', $result);
    }

    private static function stubSuccess(): PromiseInterface
    {
        //TODO (aronpc) : Verificar resposta em ingles/portugues?
        return Http::response([
            'calendar' => [
                'createdAt' => '2022-03-21T13:11:26.096Z',
                'presentation' => '2022-03-21T13:11:26.096Z',
                'dueDate' => '2022-03-21T13:11:26.096Z',
                'validateAfterExpiration' => 0,
            ],
            'debtor' => [
                'cpf' => 'string',
                'cnpj' => 'string',
                'name' => 'string',
            ],
            'receiver' => [
                'cnpj' => 'string',
                'cpf' => 'string',
                'fantasyName' => 'string',
                'publicArea' => 'string',
                'city' => 'string',
                'state' => 'string',
                'postalCode' => 'string',
            ],
            'transactionIdentification' => 'string',
            'revision' => 'string',
            'status' => 'string',
            'key' => 'string',
            'amount' => [
                'original' => 'string',
                'abatement' => 'string',
                'discount' => 'string',
                'interest' => 'string',
                'fine' => 'string',
                'final' => 'string',
            ],
            'additionalInformation' => [
                [
                    'value' => 'Assinatura de serviço',
                    'key' => 'Produto 1',
                ],
            ],
        ], Response::HTTP_OK);
    }

    /**
     * @throws RequestException
     */
    final public function testPayloadCobvNotFound(): void
    {
        $transactionId = 123456;
        $fetchUrl = sprintf(
            '%s%s',
            config('celcoin.api_url'),
            sprintf(
                '%s?%s',
                CelcoinPIXCOBV::GET_COBV_PIX,
                http_build_query(compact('transactionId')),
            ),
        );

        Http::fake(
            [
                config('celcoin.login_url') => GlobalStubs::loginResponse(),
                config('celcoin.api_url') . sprintf(
                    CelcoinPIXCOBV::PAYLOAD_COBV_PIX,
                    urlencode(Str::replace('https://', '', $fetchUrl))
                ) => self::stubNotFound(),
            ],
        );

        $this->expectException(RequestException::class);
        try {
            $pixCOB = new CelcoinPIXCOBV();
            $pixCOB->payloadCOBVPIX($fetchUrl);
        } catch (RequestException $exception) {
            $result = $exception->response->json();
            $this->assertEquals('400', $result['errorCode']);
            throw $exception;
        }
    }

    private static function stubNotFound(): PromiseInterface
    {
        return Http::response(
            [
                'message' => 'The BRCode is expired and can\'t be paid.',
                'errorCode' => '400',
            ],
            Response::HTTP_BAD_REQUEST,
        );
    }

    /**
     * @throws RequestException
     */
    final public function testPayloadCobvInvalidUrl(): void
    {
        $fetchUrl = 'url para dar erro';
        Http::fake(
            [
                config('celcoin.login_url') => GlobalStubs::loginResponse(),
                sprintf(
                    '%s?%s',
                    CelcoinPIXCOBV::PAYLOAD_COBV_PIX,
                    http_build_query(['url' => $fetchUrl]),
                ) => Http::response([], Response::HTTP_BAD_REQUEST),
            ],
        );

        $this->expectException(ValidationException::class);
        try {
            $pixCOB = new CelcoinPIXCOBV();
            $pixCOB->payloadCOBVPIX($fetchUrl);
        } catch (ValidationException $exception) {
            $errors = $exception->errors();
            $this->assertArrayHasKey('url', $errors);
            throw $exception;
        }
    }
}
