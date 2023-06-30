<?php

namespace Tests\Integration\PIX\COB;

use GuzzleHttp\Promise\PromiseInterface;
use Illuminate\Http\Client\RequestException;
use Illuminate\Support\Facades\Http;
use Illuminate\Validation\ValidationException;
use Symfony\Component\HttpFoundation\Response;
use Tests\GlobalStubs;
use Tests\TestCase;
use WeDevBr\Celcoin\Clients\CelcoinPIXCOB;
use WeDevBr\Celcoin\Types\PIX\COBGet;

class COBGetTest extends TestCase
{

    /**
     * @throws RequestException
     * @dataProvider searchDataProvider
     */
    final public function testGetCob(array $searchParam): void
    {
        Http::fake(
            [
                config('celcoin.login_url') => GlobalStubs::loginResponse(),
                sprintf('%s?%s',
                    CelcoinPIXCOB::GET_COB_PIX_URL,
                    http_build_query($searchParam)
                ) => self::stubSuccess(),
            ]
        );
        $data = new COBGet($searchParam);
        $pixCOB = new CelcoinPIXCOB();

        $result = $pixCOB->getCOBPIX($data);
        $this->assertEquals('ACTIVE', $result['status']);
        $this->assertEquals(15.63, $result['amount']['original']);
    }

    private static function stubSuccess(): PromiseInterface
    {
        return Http::response([
            'transactionId' => 817849685,
            'status' => 'ACTIVE',
            'lastUpdate' => '2023-06-26T22:36:23.4800282+00:00',
            'payerQuestion' => 'Não pagável após vencimento.',
            'additionalInformation' => [
                [
                    'value' => 'Assinatura de serviço',
                    'key' => 'Produto 1',
                ],
            ],
            'debtor' => [
                'name' => 'Fulano de Tal',
                'cpf' => NULL,
                'cnpj' => '00190305000103',
            ],
            'amount' => [
                'original' => 15.63,
                'changeType' => 0,
                'withdrawal' => NULL,
                'change' => NULL,
            ],
            'key' => 'testepix@celcoin.com.br',
            'location' => [
                'merchant' => [
                    'postalCode' => '01201005',
                    'city' => 'Barueri',
                    'merchantCategoryCode' => '0000',
                    'name' => 'Celcoin Pagamentos',
                ],
                'url' => 'api-h.developer.btgpactual.com/pc/p/v2/1d53f8a4839641628b2d678f7ddb9ad6',
                'emv' => '00020101021226930014br.gov.bcb.pix2571api-h.developer.btgpactual.com/pc/p/v2/1d53f8a4839641628b2d678f7ddb9ad65204000053039865802BR5918Celcoin Pagamentos6007Barueri61080120100562070503***63040D56',
                'type' => 'COB',
                'locationId' => NULL,
                'id' => NULL,
            ],
            'revision' => NULL,
            'calendar' => [
                'expiration' => 86400,
            ],
            'createAt' => '2023-06-26T22:36:23.4800282+00:00',
            'clientRequestId' => '14232341231',
            'transactionIdentification' => 'kk6g232xel65a0daee4dd13kk817849685',
            'transactionIdPayment' => 0,
        ], Response::HTTP_OK);
    }

    /**
     * @throws RequestException
     * @dataProvider searchDataProvider
     */
    final public function testGetCobNotFound(array $searchParam): void
    {
        Http::fake(
            [
                config('celcoin.login_url') => GlobalStubs::loginResponse(),
                sprintf('%s?%s',
                    CelcoinPIXCOB::GET_COB_PIX_URL,
                    http_build_query($searchParam)
                ) => self::stubNotFound(),
            ]
        );

        $this->expectException(RequestException::class);

        try {
            $data = new COBGet($searchParam);
            $pixCOB = new CelcoinPIXCOB();
            $pixCOB->getCOBPIX($data);
        } catch (RequestException $throwable) {
            $result = $throwable->response->json();
            $this->assertEquals('VL002', $result['errorCode']);
            throw $throwable;
        }

    }

    private static function stubNotFound(): PromiseInterface
    {
        return Http::response([
            'message' => 'Não foi possível localizar a cobrança associada ao parâmetro informado.',
            'errorCode' => 'VL002'
        ], Response::HTTP_NOT_FOUND);
    }

    /**
     * @throws RequestException
     * @dataProvider paramErrosDataProvider
     */
    final public function testGetCobParamsError(string $key): void
    {
        Http::fake(
            [
                config('celcoin.login_url') => GlobalStubs::loginResponse(),
                CelcoinPIXCOB::GET_COB_PIX_URL => self::stubSuccess(),
            ]
        );

        $this->expectException(ValidationException::class);
        try {
            $pixCOB = new CelcoinPIXCOB();
            $pixCOB->getCOBPIX(new COBGet());
        } catch (ValidationException $throwable) {
            $this->assertArrayHasKey($key, $throwable->errors());
            throw $throwable;
        }

    }

    private function paramErrosDataProvider(): array
    {
        return [
            'transactionId' => ['transactionId'],
            'clientRequestId' => ['clientRequestId'],
            'transactionIdentification' => ['transactionIdentification'],
        ];
    }

    private function searchDataProvider(): array
    {
        return [
            'transactionId' => [['transactionId' => 123456]],
            'clientRequestId' => [['clientRequestId' => 123456]],
            'transactionIdentification' => [['transactionIdentification' => 123456]],
        ];
    }
}
