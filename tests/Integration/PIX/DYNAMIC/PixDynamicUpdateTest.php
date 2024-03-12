<?php

namespace WeDevBr\Celcoin\Tests\Integration\PIX\DYNAMIC;

use GuzzleHttp\Promise\PromiseInterface;
use Illuminate\Http\Client\RequestException;
use Illuminate\Support\Facades\Http;
use Illuminate\Validation\ValidationException;
use Symfony\Component\HttpFoundation\Response;
use WeDevBr\Celcoin\Clients\CelcoinPIXDynamic;
use WeDevBr\Celcoin\Tests\GlobalStubs;
use WeDevBr\Celcoin\Tests\TestCase;
use WeDevBr\Celcoin\Types\PIX\AdditionalInformation;
use WeDevBr\Celcoin\Types\PIX\DynamicQRUpdate;
use WeDevBr\Celcoin\Types\PIX\Merchant;

class PixDynamicUpdateTest extends TestCase
{
    // Todo: não tem erros esse endpoint? 404? 422?
    /**
     * @return void
     * @throws RequestException
     */
    final public function testUpdateDynamicQRCodeInvalidKey(): void
    {
        $transactionId = 123456;

        Http::fake(
            [
                config('celcoin.login_url') => GlobalStubs::loginResponse(),
                sprintf(CelcoinPIXDynamic::UPDATE_DYNAMIC_QRCODE_ENDPOINT, $transactionId) => self::stubInvalidKey(),
            ],
        );
        $this->expectException(RequestException::class);
        try {
            $pix = new CelcoinPIXDynamic();
            $pix->updateDynamicQRCode($transactionId, self::fakeBody());
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
            Response::HTTP_BAD_REQUEST,
        );
    }

    /**
     * @return DynamicQRUpdate
     */
    static private function fakeBody(): DynamicQRUpdate
    {
        $dynamic = new DynamicQRUpdate;
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

        $information = new AdditionalInformation();
        $information->key = 'key of information';
        $information->value = 'value of information';

        $dynamic->additionalInformation[] = $information;

        $dynamic->expiration = 3600;

        return $dynamic;
    }

    /**
     * @throws RequestException
     * @dataProvider updateErrorDataProvider
     */
    final public function testUpdateDynamicQRCodeWithoutField(string $unsetValue): void
    {
        $transactionId = 123456;
        Http::fake(
            [
                config('celcoin.login_url') => GlobalStubs::loginResponse(),
                sprintf(CelcoinPIXDynamic::UPDATE_DYNAMIC_QRCODE_ENDPOINT, $transactionId) => self::stubSuccess(),
            ],
        );

        $data = self::fakeBody();

        unset($data->$unsetValue);

        $this->expectException(ValidationException::class);
        try {
            $pix = new CelcoinPIXDynamic();
            $pix->updateDynamicQRCode($transactionId, $data);
        } catch (ValidationException $exception) {
            $this->assertArrayHasKey($unsetValue, $exception->errors());
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
                'status' => 201,
                'body' => [
                    'clientRequestId' => '456456456',
                    'pactualId' => '3641c1eb-18cf-4960-b5f7-e62a7941f4ca',
                    'transactionId' => '9193296',
                    'createTimestamp' => '2022-03-22T18:59:28.0944527+00:00',
                    'lastUpdateTimestamp' => '2022-03-22T18:59:28.0944527+00:00',
                    'entity' => 'PixImmediateCollection',
                    'status' => 'ACTIVE',
                    'tags' => null,
                    'transactionIdentification' => 'kk6g232xel65a0daee4dd13kk9193296',
                    'body' => [
                        'key' => 'teste@celcoin.com.br',
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
                            'cpf' => '74881162080',
                            'cnpj' => null,
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
                            'merchantName' => 'VALDIR DE SOUSA BESERRA',
                            'merchantCity' => 'Sao Paulo',
                            'transactionIdentification' => '***',
                            'transactionAmount' => '25.25',
                            'emvqrcps' => '00020101021226930014br.gov.bcb.pix2571api-h.developer.btgpactual.com/v1/p/v2/3641c1eb18cf4960b5f7e62a7941f4ca5204000053039865802BR5923VALDIR DE SOUSA BESERRA6009Sao Paulo61080955000062070503***6304539D',
                        ],
                    ],
                ],
            ],
            Response::HTTP_OK,
        );
    }

    /**
     * @return array[]
     */
    final public static function updateErrorDataProvider(): array
    {
        return [
            'required key' => ['key'],
        ];
    }

    /**
     * @return void
     * @throws RequestException
     */
    final public function testUpdateDynamicQRCodeSuccess(): void
    {
        $transactionId = 123456;
        Http::fake(
            [
                config('celcoin.login_url') => GlobalStubs::loginResponse(),
                sprintf(CelcoinPIXDynamic::UPDATE_DYNAMIC_QRCODE_ENDPOINT, $transactionId) => self::stubSuccess(),
            ],
        );

        $pix = new CelcoinPIXDynamic();
        $response = $pix->updateDynamicQRCode($transactionId, self::fakeBody());

        $this->assertEquals(201, $response['status']);
        $this->assertEquals('ACTIVE', $response['body']['status']);
    }

}
