<?php

namespace WeDevBr\Celcoin\Tests\Integration\PIX\COBV;

use GuzzleHttp\Promise\PromiseInterface;
use Illuminate\Http\Client\RequestException;
use Illuminate\Support\Facades\Http;
use Illuminate\Validation\ValidationException;
use Symfony\Component\HttpFoundation\Response;
use WeDevBr\Celcoin\Clients\CelcoinPIXCOBV;
use WeDevBr\Celcoin\Tests\GlobalStubs;
use WeDevBr\Celcoin\Tests\TestCase;

class COBVGetTest extends TestCase
{
    /**
     * @throws RequestException
     * @dataProvider testGetCobvSuccessProvider
     */
    final public function testGetCobvSuccess(array $search): void
    {
        Http::fake(
            [
                config('celcoin.login_url') => GlobalStubs::loginResponse(),
                sprintf(
                    '%s?%s',
                    CelcoinPIXCOBV::GET_COBV_PIX,
                    http_build_query($search),
                ) => self::stubSuccess(),
            ],
        );
        $pixCOBV = new CelcoinPIXCOBV();
        $result = $pixCOBV->getCOBVPIX($search);
        $this->assertEquals('ACTIVE', $result['status']);
        $this->assertEquals(15.63, $result['amount']['original']);
    }

    private static function stubSuccess(): PromiseInterface
    {
        return Http::response([
            'transactionId' => 12345345,
            'status' => 'ACTIVE',
            'lastUpdate' => '2021-04-29',
            'payerQuestion' => 'Esta cobrança é referente a...',
            'additionalInformation' => [
                [
                    'value' => 'Assinatura de serviço',
                    'key' => 'Produto 1',
                ],
            ],
            'debtor' => [
                'name' => 'Fulano de Tal',
                'cpf' => '11122233366',
                'cnpj' => '1112223300100',
                'city' => 'Barueri',
                'publicArea' => 'Avenida Brasil',
                'state' => 'SP',
                'postalCode' => '01202003',
                'email' => 'contato@celcoin.com.br',
            ],
            'amount' => [
                'original' => 15.63,
                'discount' => [
                    'discountDateFixed' => [
                        [
                            'date' => '2021-04-29',
                            'amountPerc' => '1.00',
                        ],
                    ],
                    'modality' => 'string',
                ],
                'abatement' => [
                    'amountPerc' => '1.00',
                    'modality' => 'FIXED_VALUE',
                ],
                'fine' => [
                    'amountPerc' => '1.00',
                    'modality' => 'string',
                ],
                'interest' => [
                    'amountPerc' => '1.00',
                    'modality' => 'string',
                ],
            ],
            'key' => '5d000ece-b3f0-47b3-8bdd-c183e8875862',
            'receiver' => [
                'name' => 'João da Silva',
                'cpf' => '11122233366',
                'cnpj' => '1112223300100',
                'postalCode' => '01202003',
                'city' => 'Barueri',
                'publicArea' => 'Avenida Brasil',
                'state' => 'SP',
                'fantasyName' => 'Nome de Comercial',
            ],
            'calendar' => [
                'expirationAfterPayment' => '10',
                'createdAt' => '2021-04-29',
                'dueDate' => '2021-05-10',
            ],
            'createAt' => '2021-04-29',
            'clientRequestId' => '9b26edb7cf254db09f5449c94bf13abc',
            'transactionIdentification' => 'kk6g232xel65a0daee4dd13kk479195205',
            'transactionIdPayment' => 45854857,
        ], Response::HTTP_OK);
    }

    /**
     * @throws RequestException
     */
    final public function testGetCobvNotFoundError(): void
    {
        $search = [
            'transactionId' => 123,
        ];
        Http::fake(
            [
                config('celcoin.login_url') => GlobalStubs::loginResponse(),
                sprintf(
                    '%s?%s',
                    CelcoinPIXCOBV::GET_COBV_PIX,
                    http_build_query($search),
                ) => self::stubNotFoundError(),
            ],
        );

        $this->expectException(RequestException::class);
        try {
            $pixCOBV = new CelcoinPIXCOBV();
            $pixCOBV->getCOBVPIX($search);
        } catch (RequestException $exception) {
            $result = $exception->response->json();
            $this->assertEquals('VL002', $result['errorCode']);
            throw $exception;
        }
    }

    /**
     * @return PromiseInterface
     */
    private static function stubNotFoundError(): PromiseInterface
    {
        return Http::response(
            [
                'message' => 'Não foi possível localizar a cobrança associada ao parâmetro informado.',
                'errorCode' => 'VL002',
            ],
            Response::HTTP_BAD_REQUEST,
        );
    }

    /**
     * @throws RequestException
     * @dataProvider testGetCobvValidationKeysProvider
     */
    final public function testGetCobvValidationError(string $key): void
    {
        $search = [];
        Http::fake(
            [
                config('celcoin.login_url') => GlobalStubs::loginResponse(),
                sprintf(
                    '%s?%s',
                    CelcoinPIXCOBV::GET_COBV_PIX,
                    http_build_query($search),
                ) => self::stubNotFoundError(),
            ],
        );

        $this->expectException(ValidationException::class);
        try {
            $pixCOBV = new CelcoinPIXCOBV();
            $pixCOBV->getCOBVPIX($search);
        } catch (ValidationException $exception) {
            $errors = $exception->errors();
            $this->assertArrayHasKey($key, $errors);
            throw $exception;
        }
    }

    private function testGetCobvValidationKeysProvider(): array
    {
        return [
            'transactionId' => ['transactionId'],
            'clientRequestId' => ['clientRequestId'],
            'transactionIdentification' => ['transactionIdentification'],
        ];
    }


    private function testGetCobvSuccessProvider(): array
    {
        return [
            'transactionId' => [
                [
                    'transactionId' => 12345,
                ],
            ],
            'clientRequestId' => [
                [
                    'clientRequestId' => 12345,
                ],
            ],
            'transactionIdentification' => [
                [
                    'transactionIdentification' => 12345,
                ],
            ],
        ];
    }
}