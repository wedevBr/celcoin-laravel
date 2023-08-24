<?php

namespace WeDevBr\Celcoin\Tests\Integration\PIX\QRLocation;

use Closure;
use GuzzleHttp\Promise\PromiseInterface;
use Illuminate\Http\Client\RequestException;
use Illuminate\Support\Facades\Http;
use Illuminate\Validation\ValidationException;
use Symfony\Component\HttpFoundation\Response;
use WeDevBr\Celcoin\Clients\CelcoinPixStaticPayment;
use WeDevBr\Celcoin\Tests\GlobalStubs;
use WeDevBr\Celcoin\Tests\TestCase;

class PixGetStaticPaymentDataTest extends TestCase
{

    /**
     * @param array $search
     *
     * @return void
     * @throws RequestException
     * @dataProvider searchDataProvider
     */
    final public function testSuccess(array $search): void
    {
        $locationId = 12731081;
        Http::fake(
            [
                config('celcoin.login_url') => GlobalStubs::loginResponse(),
                sprintf(
                    '%s%s?%s',
                    config('api_url'),
                    CelcoinPixStaticPayment::GET_STATIC_PAYMENT_DATA_ENDPOINT,
                    http_build_query($search),
                ) => self::stubSuccess(),
            ],
        );

        $pix = new CelcoinPixStaticPayment();
        $response = $pix->getStaticPaymentData($search);

        $keyName = key($search);
        $this->assertEquals($search[$keyName], $response[$keyName]);
        $this->assertArrayHasKey($keyName, $response);
    }

    /**
     * @return PromiseInterface
     */
    static private function stubSuccess(): PromiseInterface
    {
        return Http::response(
            [
                'key' => '5d000ece-b3f0-47b3-8bdd-c183e8875862',
                'amount' => 10.55,
                'transactionIdBrcode' => 12345345,
                'brCodeId' => 12345345,
                'createdAt' => '2023-02-16',
                'updatedAt' => '2023-02-16',
                'transactionIdentification' => 'kk6g232xel65a0daee4dd13kk479195205',
                'partnerNumber' => '9b26edb7cf254db09f5449c94bf13abc',
                'quantityPayments' => 12345345,
                'amountPayments' => 10.55,
                'additionalInformation' => 'string',
                'emvqrcps' => '00020126430014br.gov.bcb.pix0113test@test.com0204test5204000053039865406100.515802BR5912Celcoin Test6007Barueri61080120200162270523testqrcodestaticcelcoin63046F53',
                'payments' => [
                    [
                        'transactionId' => 12345345,
                        'endToEnd' => 'E3030629420200808185300887639654',
                        'createdAt' => '2023-02-16',
                        'amount' => 10.55,
                        'payerName' => 'CELCOIN TESTE INTERNO LTDA',
                        'payerTaxId' => '12345678909876',
                        'creditParty' => [
                            'bank' => '12345677',
                            'branch' => '30',
                            'account' => '1234567',
                            'name' => 'CELCOIN TESTE INTERNO LTDA',
                            'taxId' => '12345678909876',
                            'key' => 'f3197f49-2615-41eb-9df2-e6224ebb4470',
                            'personType' => 'string',
                            'accountType' => 'string',
                        ],
                        'debitParty' => [
                            'bank' => '12345677',
                            'branch' => '30',
                            'account' => '1234567',
                            'name' => 'CELCOIN TESTE INTERNO LTDA',
                            'taxId' => '12345678909876',
                            'personType' => 'string',
                            'accountType' => 'string',
                        ],
                    ],
                ],
            ],
            Response::HTTP_OK,
        );
    }

    /**
     * @param string $key
     *
     * @return void
     * @throws RequestException
     * @dataProvider createErrorDataProvider
     */
    final public function testValidationError(string $key): void
    {
        Http::fake(
            [
                config('celcoin.login_url') => GlobalStubs::loginResponse(),
                sprintf(
                    '%s%s',
                    config('api_url'),
                    CelcoinPixStaticPayment::GET_STATIC_PAYMENT_DATA_ENDPOINT,
                ) => [],
            ],
        );
        $this->expectException(ValidationException::class);
        try {
            $pix = new CelcoinPixStaticPayment();
            $pix->getStaticPaymentData([]);
        } catch (ValidationException $exception) {
            $this->assertArrayHasKey($key, $exception->errors());
            throw $exception;
        }
    }

    /**
     * @param Closure $response
     * @param int $status
     * @param array $params
     *
     * @return void
     * @throws RequestException
     * @dataProvider errorDataProvider
     */
    final public function testErrors(Closure $response, int $status, array $params): void
    {
        Http::fake(
            [
                config('celcoin.login_url') => GlobalStubs::loginResponse(),
                sprintf(
                    '%s%s?%s',
                    config('api_url'),
                    CelcoinPixStaticPayment::GET_STATIC_PAYMENT_DATA_ENDPOINT,
                    http_build_query($params),
                ) => $response,
            ],
        );
        $pix = new CelcoinPixStaticPayment();
        $response = $pix->getStaticPaymentData($params);

        $this->assertEquals($status, $response['code']);
    }

    /**
     * @return array[]
     */
    final public function createErrorDataProvider(): array
    {
        return [
            'required transactionIdBrcode' => ['transactionIdBrcode'],
            'required transactionIdentification' => ['transactionIdentification'],
        ];
    }

    private function searchDataProvider(): array
    {
        return [
            'searching by transactionIdBrcode' => [
                ['transactionIdBrcode' => 12345345],
            ],
            'searching by transactionIdentification' => [
                ['transactionIdentification' => 'kk6g232xel65a0daee4dd13kk479195205'],
            ],
        ];
    }

    /**
     * @return array[]
     */
    private function errorDataProvider(): array
    {
        return [
            'status code 400' => [
                fn() => self::stubGenericError(Response::HTTP_BAD_REQUEST),
                Response::HTTP_BAD_REQUEST,
                ['transactionIdBrcode' => 12345345],
            ],
            'status code 404' => [
                fn() => self::stubGenericError(Response::HTTP_NOT_FOUND),
                Response::HTTP_NOT_FOUND,
                ['transactionIdBrcode' => 12345345],
            ],
            'status code 500' => [
                fn() => self::stubGenericError(Response::HTTP_INTERNAL_SERVER_ERROR),
                Response::HTTP_INTERNAL_SERVER_ERROR,
                ['transactionIdBrcode' => 12345345],
            ],
        ];
    }

    /**
     * @param int $status
     *
     * @return PromiseInterface
     */
    static private function stubGenericError(int $status): PromiseInterface
    {
        return Http::response(
            [
                'code' => $status,
                'description' => 'Message',
            ],
        );
    }
}