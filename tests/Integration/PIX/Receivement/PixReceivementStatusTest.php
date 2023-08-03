<?php

namespace Tests\Integration\PIX\Receivement;


use GuzzleHttp\Promise\PromiseInterface;
use Illuminate\Http\Client\RequestException;
use Illuminate\Support\Facades\Http;
use Symfony\Component\HttpFoundation\Response;
use Tests\GlobalStubs;
use Tests\TestCase;
use WeDevBr\Celcoin\Clients as Clients;
use WeDevBr\Celcoin\Types\PIX as Types;

class PixReceivementStatusTest extends TestCase
{
    final public function testReceivementStatusNotFound(): void
    {
        $params = new Types\PixReceivementStatus();
        $params->transactionId = '1234';

        $url = sprintf(
            '%s?%s',
            Clients\CelcoinPIXReceivement::PIX_RECEIVEMENT_STATUS_ENDPOINT,
            http_build_query($params->toArray())
        );
        Http::fake(
            [
                config('celcoin.login_url') => GlobalStubs::loginResponse(),
                sprintf(
                    '%s%s',
                    config('api_url'),
                    $url
                ) => self::stubErrorNotFound()
            ]
        );

        $this->expectException(RequestException::class);
        try {
            $pix = new Clients\CelcoinPIXReceivement();
            $pix->getStatus($params);
        } catch (RequestException $exception) {
            $response = $exception->response->json();
            $this->assertEquals('99', $response['errorCode']);
            throw $exception;
        }
    }

    static public function stubErrorNotFound(): PromiseInterface
    {
        return Http::response(
            [
                'errorCode' => '99',
                'description' => 'Transação de recebimento não encontrada.',
            ],
            Response::HTTP_BAD_REQUEST
        );
    }

    /**
     * @throws RequestException
     */
    final public function testReceivementStatusSuccess(): void
    {
        $params = new Types\PixReceivementStatus();
        $params->transactionId = '1234';

        $url = sprintf(
            '%s?%s',
            Clients\CelcoinPIXReceivement::PIX_RECEIVEMENT_STATUS_ENDPOINT,
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

        $pix = new Clients\CelcoinPIXReceivement();
        $response = $pix->getStatus($params);
        $this->assertArrayHasKey('transactionId', $response['requestBody']);
    }

    private static function stubSuccess(): PromiseInterface
    {
        return Http::response(
            [
                'requestBody' => [
                    'transactionType' => 'RECEIVEPIX',
                    'transactionId' => 761679887,
                    'amount' => 118,
                    'debitParty' => [
                        'account' => '1234567',
                        'bank' => '12345678',
                        'branch' => '30',
                        'personType' => 'NATURAL_PERSON',
                        'taxId' => '12345678901',
                        'accountType' => 'CACC',
                        'name' => 'Celcoin TESTE Ltda',
                    ],
                    'creditParty' => [
                        'bank' => '12345677',
                        'branch' => '30',
                        'account' => '1234567',
                        'personType' => 'LEGAL_PERSON',
                        'taxId' => '12345678000123',
                        'accountType' => 'CACC',
                        'name' => 'CELCOIN TESTE INTERNO LTDA',
                        'key' => 'f3197f49-2615-41eb-9df2-e6224ebb4470',
                    ],
                    'endToEndId' => 'E18236120202001199999s0149012FPC',
                    'transactionIdentification' => 'kk6g232xel65a0daee4dd13kk761678748',
                    'transactionIdBRCode' => '761678748',
                    'initiationType' => 'MANUAL',
                    'transactionTypePix' => 'TRANSFER',
                    'paymentType' => 'IMMEDIATE',
                    'urgency' => 'HIGH',
                ],
            ],
            Response::HTTP_OK
        );
    }
}
