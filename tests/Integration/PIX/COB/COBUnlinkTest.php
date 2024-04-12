<?php

namespace WeDevBr\Celcoin\Tests\Integration\PIX\COB;

use GuzzleHttp\Promise\PromiseInterface;
use Illuminate\Http\Client\RequestException;
use Illuminate\Support\Facades\Http;
use Symfony\Component\HttpFoundation\Response;
use WeDevBr\Celcoin\Clients\CelcoinPIXCOB;
use WeDevBr\Celcoin\Tests\GlobalStubs;
use WeDevBr\Celcoin\Tests\TestCase;

class COBUnlinkTest extends TestCase
{
    /**
     * @throws RequestException
     */
    final public function testUnlinkBrcodeFromCobSuccess(): void
    {
        $transactionId = 123456;
        Http::fake(
            [
                config('celcoin.login_url') => GlobalStubs::loginResponse(),
                sprintf(CelcoinPIXCOB::UNLINK_COB_PIX_URL, $transactionId) => self::stubSuccess(),
            ],
        );
        $pixCOB = new CelcoinPIXCOB();
        $result = $pixCOB->unlinkCOBPIX($transactionId);

        $this->assertEquals('ACTIVE', $result['status']);
        $this->assertEquals(15.01, $result['amount']['original']);
    }

    private static function stubSuccess(): array
    {
        return
            [
                'revision' => 0,
                'transactionId' => 0,
                'clientRequestId' => '',
                'status' => 'ACTIVE',
                'lastUpdate' => '2022-03-22T12:49:21.2461549+00:00',
                'payerQuestion' => null,
                'additionalInformation' => null,
                'debtor' => [
                    'name' => 'teste',
                    'cpf' => '35914875417',
                    'cnpj' => null,
                ],
                'amount' => [
                    'original' => 15.01,
                    'changeType' => 0,
                    'withdrawal' => null,
                    'change' => null,
                ],
                'location' => null,
                'key' => 'testepix@celcoin.com.br',
                'calendar' => [
                    'expiration' => 86400,
                ],
                'createAt' => '2022-03-22T12:48:45.0602272+00:00',
                'transactionIdentification' => 'kk6g232xel65a0daee4dd13kk9191767',
            ];
    }

    /**
     * @throws RequestException
     */
    final public function testUnlinkBrcodeFromCobNotFoundError(): void
    {
        $transactionId = 123456;
        Http::fake(
            [
                config('celcoin.login_url') => GlobalStubs::loginResponse(),
                sprintf(CelcoinPIXCOB::UNLINK_COB_PIX_URL, $transactionId) => self::stubNotFoundError(),
            ],
        );
        $this->expectException(RequestException::class);
        try {
            $pixCOB = new CelcoinPIXCOB();
            $pixCOB->unlinkCOBPIX($transactionId);
        } catch (RequestException $exception) {
            $response = $exception->response->json();
            $this->assertEquals('404', $response['errorCode']);
            throw $exception;
        }
    }

    private static function stubNotFoundError(): PromiseInterface
    {
        return Http::response(
            [
                'message' => '{\'version\':\'1.2.7\',\'status\':404}',
                'errorCode' => '404',
            ],
            Response::HTTP_NOT_FOUND,
        );
    }
}
