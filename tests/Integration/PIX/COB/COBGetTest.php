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
            'transactionId' => 817852711,
            'status' => 'ACTIVE',
            'lastUpdate' => '2023-06-28T00:53:41.8681786+00:00',
            'payerQuestion' => NULL,
            'additionalInformation' => NULL,
            'debtor' => [
                'name' => 'Fulano de Tal',
                'cpf' => NULL,
                'cnpj' => '61360961000100',
                'city' => 'Barueri',
                'publicArea' => 'Avenida Brasil',
                'state' => 'SP',
                'postalCode' => '01202003',
                'email' => 'umdoistres@celcoin.com.br',
            ],
            'amount' => [
                'original' => 15.63,
                'discount' => [
                    'discountDateFixed' => [
                        [
                            'date' => '2023-12-10T00:00:00',
                            'amountPerc' => '1.00',
                        ],
                    ],
                    'modality' => 'FIXED_VALUE_UNTIL_THE_DATES_INFORMED',
                    'amountPerc' => NULL,
                ],
                'abatement' => NULL,
                'fine' => NULL,
                'interest' => NULL,
            ],
            'key' => 'testepix@celcoin.com.br',
            'receiver' => [
                'name' => 'João da Silva',
                'cpf' => NULL,
                'cnpj' => '60904237000129',
                'postalCode' => '01202003',
                'city' => 'Barueri',
                'publicArea' => 'Avenida Brasil',
                'state' => 'SP',
                'fantasyName' => 'Nome de Comercial',
            ],
            'calendar' => [
                'expirationAfterPayment' => '10',
                'createdAt' => '0001-01-01T00:00:00',
                'dueDate' => '2023-12-15T00:00:00',
            ],
            'createAt' => '2023-06-28T00:53:41.8681786+00:00',
            'clientRequestId' => '12341235123213',
            'transactionIdentification' => 'kk6g232xel65a0daee4dd13kk817852711',
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
        $data = new COBGet($searchParam);
        $pixCOB = new CelcoinPIXCOB();

        $result = $pixCOB->getCOBPIX($data);
        $this->assertEquals('VL002', $result['errorCode']);
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
