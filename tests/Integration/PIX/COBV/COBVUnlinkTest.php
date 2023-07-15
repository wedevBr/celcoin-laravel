<?php

namespace Tests\Integration\PIX\COBV;

use GuzzleHttp\Promise\PromiseInterface;
use Illuminate\Http\Client\RequestException;
use Illuminate\Support\Facades\Http;
use Symfony\Component\HttpFoundation\Response;
use Tests\GlobalStubs;
use Tests\TestCase;
use WeDevBr\Celcoin\Clients\CelcoinPIXCOBV;

class COBVUnlinkTest extends TestCase
{

    /**
     * @throws RequestException
     */
    final public function testUnlinkCobvNotFoundError(): void
    {
        $transactionId = 123456;
        Http::fake(
            [
                config('celcoin.login_url') => GlobalStubs::loginResponse(),
                sprintf(CelcoinPIXCOBV::UNLINK_COB_PIX_URL, $transactionId) => self::stubNotFoundError(),
            ]
        );

        $this->expectException(RequestException::class);
        try {
            $pixCOBV = new CelcoinPIXCOBV();
            $pixCOBV->unlinkCOBVPIX($transactionId);
        } catch (RequestException $exception) {
            $result = $exception->response->json();
            $this->assertEquals(404, $result['errorCode']);
            throw $exception;
        }
    }

    static private function stubNotFoundError(): PromiseInterface
    {
        return Http::response(
            [
                'message' => 'Não foram encontrados dados para a transação informada.',
                'errorCode' => '404',
            ],
            Response::HTTP_NOT_FOUND
        );
    }

    /**
     * @throws RequestException
     */
    final public function testUnlinkCobvSuccess(): void
    {
        $transactionId = 123456;
        Http::fake(
            [
                config('celcoin.login_url') => GlobalStubs::loginResponse(),
                sprintf(CelcoinPIXCOBV::UNLINK_COB_PIX_URL, $transactionId) => self::stubSuccess(),
            ]
        );
        $pixCOBV = new CelcoinPIXCOBV();
        $result = $pixCOBV->unlinkCOBVPIX($transactionId);

        $this->assertEquals('ACTIVE', $result['status']);
        $this->assertEquals(15.63, $result['body']['amount']['original']);
    }

    static private function stubSuccess(): PromiseInterface
    {
        return Http::response(
            [
                'clientRequestId' => 'kk6g232xel65a0daee4dd13kk9189382',
                'status' => 'ACTIVE',
                'lastUpdateTimestamp' => '2022-03-21T16:43:54.4223057+00:00',
                'entity' => 'PixCollectionDueDate',
                'pactualId' => 'f7352171-e983-4d91-8073-c2e513b83ce6',
                'createTimestamp' => '2022-03-21T14:27:58.2106288+00:00',
                'body' => [
                    'payerQuestion' => NULL,
                    'additionalInformation' => NULL,
                    'key' => 'testepix@celcoin.com.br',
                    'amount' => [
                        'original' => 15.63,
                    ],
                    'debtor' => [
                        'name' => 'Fulano de Tal',
                        'cpf' => NULL,
                        'cnpj' => '33188542046',
                    ],
                    'calendar' => [
                        'expiration' => 86400,
                    ],
                ],
            ],
            Response::HTTP_OK
        );
    }
}
