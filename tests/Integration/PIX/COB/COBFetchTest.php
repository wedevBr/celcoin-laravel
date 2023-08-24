<?php

namespace WeDevBr\Celcoin\Tests\Integration\PIX\COB;

use GuzzleHttp\Promise\PromiseInterface;
use Illuminate\Http\Client\RequestException;
use Illuminate\Support\Facades\Http;
use Symfony\Component\HttpFoundation\Response;
use WeDevBr\Celcoin\Clients\CelcoinPIXCOB;
use WeDevBr\Celcoin\Tests\GlobalStubs;
use WeDevBr\Celcoin\Tests\TestCase;

class COBFetchTest extends TestCase
{
    /**
     * @throws RequestException
     */
    final public function testFetchCobSuccess(): void
    {
        $transactionId = 123456;
        Http::fake(
            [
                config('celcoin.login_url') => GlobalStubs::loginResponse(),
                sprintf(CelcoinPIXCOB::FETCH_COB_PIX_URL, $transactionId) => self::stubSuccess(),
            ],
        );

        $pixCOB = new CelcoinPIXCOB();
        $result = $pixCOB->fetchCOBPIX($transactionId);
        $this->assertEquals('ACTIVE', $result['status']);
        $this->assertEquals(15.01, $result['amount']['original']);
    }

    private static function stubSuccess(): PromiseInterface
    {
        return Http::response([
            'transactionId' => 9191641,
            'status' => 'ACTIVE',
            'lastUpdate' => '2022-03-22T12:13:50.7339728+00:00',
            'payerQuestion' => null,
            'additionalInformation' => null,
            'debtor' => [
                'name' => 'valdir',
                'cpf' => '35814746814',
                'cnpj' => null,
            ],
            'amount' => [
                'original' => 15.01,
                'changeType' => 0,
                'withdrawal' => null,
                'change' => null,
            ],
            'key' => 'testepix@celcoin.com.br',
            'location' => [
                'merchant' => [
                    'postalCode' => '01201005',
                    'city' => 'Barueri',
                    'merchantCategoryCode' => '0000',
                    'name' => 'Celcoin Pagamentos',
                ],
                'url' => 'api-h.developer.btgpactual.com/v1/p/v2/0e3c73a70189497294c08ef7aa16ffeb',
                'emv' => '00020101021226930014br.gov.bcb.pix2571api-h.developer.btgpactual.com/v1/p/v2/0e3c73a70189497294c08ef7aa16ffeb5204000053039865802BR5918Celcoin Pagamentos6007Barueri61080120100562070503***6304231F',
                'type' => 'COB',
                'locationId' => null,
                'id' => null,
            ],
            'revision' => null,
            'calendar' => [
                'expiration' => 86400,
            ],
            'createAt' => '2022-03-22T12:13:50.7339728+00:00',
            'clientRequestId' => '9b26edb7cf254db09f5449c94bf13abc',
            'transactionIdentification' => 'kk6g232xel65a0daee4dd13kk9191641',
            'transactionIdPayment' => 0,
        ], Response::HTTP_OK);
    }

    /**
     * @throws RequestException
     */
    final public function testFetchCobNotFound(): void
    {
        $transactionId = 123456;
        Http::fake(
            [
                config('celcoin.login_url') => GlobalStubs::loginResponse(),
                sprintf(CelcoinPIXCOB::FETCH_COB_PIX_URL, $transactionId) => self::stubNotFound(),
            ],
        );

        $this->expectException(RequestException::class);
        try {
            $pixCOB = new CelcoinPIXCOB();
            $pixCOB->fetchCOBPIX($transactionId);
        } catch (RequestException $exception) {
            $result = $exception->response->json();
            $this->assertEquals('VL002', $result['errorCode']);
            throw $exception;
        }
    }

    /**
     * @return PromiseInterface
     */
    private static function stubNotFound(): PromiseInterface
    {
        return Http::response([
            'message' => 'Não foi possível localizar a cobrança associada ao parâmetro informado.',
            'errorCode' => 'VL002',
        ],
            Response::HTTP_BAD_REQUEST,
        );
    }
}
