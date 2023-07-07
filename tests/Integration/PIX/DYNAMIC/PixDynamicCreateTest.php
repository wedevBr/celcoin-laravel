<?php

namespace Tests\Integration\PIX\DYNAMIC;

use GuzzleHttp\Promise\PromiseInterface;
use Illuminate\Http\Client\RequestException;
use Illuminate\Support\Facades\Http;
use Illuminate\Validation\ValidationException;
use Symfony\Component\HttpFoundation\Response;
use Tests\GlobalStubs;
use Tests\TestCase;
use WeDevBr\Celcoin\Clients\CelcoinPIXDynamic;
use WeDevBr\Celcoin\Types\PIX\AdditionalInformation;
use WeDevBr\Celcoin\Types\PIX\DynamicQRCreate;
use WeDevBr\Celcoin\Types\PIX\Merchant;

class PixDynamicCreateTest extends TestCase
{
    // Todo: não tem erros esse endpoint? 404? 422?
    /**
     * @return void
     * @throws RequestException
     */
    final public function testCreateDynamicQRCodeInvalidKey(): void
    {
        Http::fake(
            [
                config('celcoin.login_url') => GlobalStubs::loginResponse(),
                CelcoinPIXDynamic::CREATE_DYNAMIC_QRCODE_ENDPOINT => self::stubInvalidKey()
            ]
        );
        $this->expectException(RequestException::class);
        try {
            $pix = new CelcoinPIXDynamic();
            $pix->createDynamicQRCode(self::fakeBody());
        } catch (RequestException $exception) {
            $response = $exception->response->json();
            $this->assertEquals('LC003', $response['code']);
            throw $exception;
        }
    }

    /**
     * @return PromiseInterface
     */
    static private function stubInvalidKey(): PromiseInterface
    {
        return Http::response(
            [
                'code' => 'LC003',
                'description' => 'Chave Pix informada não é válida para este tipo de ação. Contate o suporte. / Chave informada não cadastrada',
            ],
            Response::HTTP_BAD_REQUEST
        );
    }

    /**
     * @return DynamicQRCreate
     */
    static private function fakeBody(): DynamicQRCreate
    {

        $dynamic = new DynamicQRCreate();
        $dynamic->clientRequestId = '9b26edb7cf254db09f5449c94bf13abc';
        $dynamic->key = 'testepix@celcoin.com.br';
        $dynamic->amount = 15.63;

        $dynamic->merchant = new Merchant();
        $dynamic->merchant->name = 'Fulano de Tal';
        $dynamic->merchant->city = 'Barueri';
        $dynamic->merchant->postalCode = '01202003';
        $dynamic->merchant->merchantCategoryCode = '0000';

        $dynamic->payerCpf = '60956496091';
        $dynamic->payerCnpj = '61360961000100';

        $dynamic->payerQuestion = 'Payer question';
        $dynamic->payerName = 'Fulano de tal';

        $dynamic->additionalInformation = [];

        $information = new AdditionalInformation();
        $information->key = 'key of information';
        $information->value = 'value of information';

        $dynamic->additionalInformation[] = $information;

        $dynamic->expiration = 3600;

        return $dynamic;
    }


    /**
     * @throws RequestException
     */
    final public function testCreateDynamicQRCodeWithoutPayerDocument(): void
    {
        Http::fake(
            [
                config('celcoin.login_url') => GlobalStubs::loginResponse(),
                CelcoinPIXDynamic::CREATE_DYNAMIC_QRCODE_ENDPOINT => self::stubSuccess(),
            ]
        );

        $data = self::fakeBody();

        unset($data->payerCnpj);
        unset($data->payerCpf);

        $this->expectException(ValidationException::class);
        try {
            $pix = new CelcoinPIXDynamic();
            $pix->createDynamicQRCode($data);
        } catch (ValidationException $exception) {
            $this->assertArrayHasKey('payerCpf', $exception->errors());
            $this->assertArrayHasKey('payerCnpj', $exception->errors());
            throw $exception;
        }
    }

    /**
     * @return PromiseInterface
     */
    static private function stubSuccess(): PromiseInterface
    {
        return Http::response(
            [
                'version' => '1.0.9',
                'status' => 200,
                'body' => [
                    'clientRequestId' => '456456456',
                    'pactualId' => '3641c1eb-18cf-4960-b5f7-e62a7941f4ca',
                    'transactionId' => '9193296',
                    'createTimestamp' => '2022-03-22T18:59:28.0944527+00:00',
                    'lastUpdateTimestamp' => '2022-03-22T18:59:28.0944527+00:00',
                    'entity' => 'PixImmediateCollection',
                    'status' => 'ACTIVE',
                    'tags' => NULL,
                    'transactionIdentification' => 'kk6g232xel65a0daee4dd13kk9193296',
                    'body' => [
                        'key' => 'testepix@celcoin.com.br',
                        'revision' => '0',
                        'location' => 'api-h.developer.btgpactual.com/v1/p/v2/3641c1eb18cf4960b5f7e62a7941f4ca',
                        'amount' => [
                            'original' => 25.25,
                        ],
                        'calendar' => [
                            'expiration' => 86400,
                            'dueDate' => '2022-03-23T18:59:28.1220525+00:00',
                        ],
                        'debtor' => [
                            'cpf' => '12312312312',
                            'cnpj' => NULL,
                            'name' => 'valdir',
                        ],
                        'additionalInformation' => [
                        ],
                        'dynamicBRCodeData' => [
                            'pointOfInitiationMethod' => '',
                            'merchantAccountInformation' => [
                                'url' => 'api-h.developer.btgpactual.com/v1/p/v2/3641c1eb18cf4960b5f7e62a7941f4ca',
                            ],
                            'payloadFormatIndicator' => '',
                            'merchantCategoryCode' => 0,
                            'transactionCurrency' => 986,
                            'countryCode' => 'BR',
                            'merchantName' => 'Celcoin',
                            'merchantCity' => 'Sao Paulo',
                            'transactionIdentification' => '***',
                            'transactionAmount' => '25.25',
                            'emvqrcps' => '00020101021226930014br.gov.bcb.pix2571api-h.developer.btgpactual.com/v1/p/v2/3641c1eb18cf4960b5f7e62a7941f4ca5204000053039865802BR5923VALDIR DE SOUSA BESERRA6009Sao Paulo61080955000062070503***6304539D',
                        ],
                    ],
                ],
            ],
            Response::HTTP_OK
        );
    }

    /**
     * @throws RequestException
     * @dataProvider createErrorDataProvider
     */
    final public function testCreateDynamicQRCodeWithoutField(string $unsetValue): void
    {
        Http::fake(
            [
                config('celcoin.login_url') => GlobalStubs::loginResponse(),
                CelcoinPIXDynamic::CREATE_DYNAMIC_QRCODE_ENDPOINT => self::stubSuccess(),
            ]
        );

        $data = self::fakeBody();

        unset($data->$unsetValue);

        $this->expectException(ValidationException::class);
        try {
            $pix = new CelcoinPIXDynamic();
            $pix->createDynamicQRCode($data);
        } catch (ValidationException $exception) {
            $this->assertArrayHasKey($unsetValue, $exception->errors());
            throw $exception;
        }
    }

    /**
     * @return array[]
     */
    final public function createErrorDataProvider(): array
    {
        return [
            'required clientRequestId' => ['clientRequestId'],
            'required key' => ['key'],
            'required amount' => ['amount'],
            'required payerName' => ['payerName'],
            'required expiration' => ['expiration'],
        ];
    }

    /**
     * @return void
     * @throws RequestException
     */
    final public function testCreateDynamicQRCodeSuccess(): void
    {
        Http::fake(
            [
                config('celcoin.login_url') => GlobalStubs::loginResponse(),
                CelcoinPIXDynamic::CREATE_DYNAMIC_QRCODE_ENDPOINT => self::stubSuccess()
            ]
        );

        $pix = new CelcoinPIXDynamic();
        $response = $pix->createDynamicQRCode(self::fakeBody());

        $this->assertEquals(Response::HTTP_OK, $response['status']);
        $this->assertEquals('ACTIVE', $response['body']['status']);
    }

}
