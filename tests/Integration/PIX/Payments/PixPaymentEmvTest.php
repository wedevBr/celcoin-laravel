<?php

namespace Tests\Integration\PIX\Payments;

use GuzzleHttp\Promise\PromiseInterface;
use Illuminate\Http\Client\RequestException;
use Illuminate\Support\Facades\Http;
use Symfony\Component\HttpFoundation\Response;
use Tests\GlobalStubs;
use Tests\TestCase;
use WeDevBr\Celcoin\Clients\CelcoinPIXPayment;
use WeDevBr\Celcoin\Types\PIX\PaymentEmv;

class PixPaymentEmvTest extends TestCase
{
    /**
     * @throws RequestException
     */
    final public function testEmvError(): void
    {
        Http::fake(
            [
                config('celcoin.login_url') => GlobalStubs::loginResponse(),
                sprintf(
                    '%s%s',
                    config('api_url'),
                    CelcoinPIXPayment::EMV_PAYMENT_ENDPOINT
                ) => self::stubEmvError()
            ]
        );

        $params = new PaymentEmv();
        $params->emv = 'meu-emv.test';

        $this->expectException(RequestException::class);
        try {
            $pix = new CelcoinPIXPayment();
            $pix->emvPayment($params);
        } catch (RequestException $exception) {
            $response = $exception->response->json();
            $this->assertEquals(Response::HTTP_BAD_REQUEST, $response['status']);
            $this->assertEquals('PCE002', $response['errors'][0]['errorCode']);
            throw $exception;
        }
    }

    private static function stubEmvError(): PromiseInterface
    {
        return Http::response(
            [
                'version' => '1.3.8',
                'status' => 400,
                'errors' => [
                    0 => [
                        'message' => 'Error reading emv: [Failed To Decode].',
                        'errorCode' => 'PCE002',
                    ],
                ],
            ],
            Response::HTTP_BAD_REQUEST
        );
    }

    /**
     * @throws RequestException
     */
    final public function testEmvSuccess(): void
    {
        Http::fake(
            [
                config('celcoin.login_url') => GlobalStubs::loginResponse(),
                sprintf(
                    '%s%s',
                    config('api_url'),
                    CelcoinPIXPayment::EMV_PAYMENT_ENDPOINT
                ) => self::stubSuccess()
            ]
        );

        $params = new PaymentEmv();
        $params->emv = 'meu-emv.test';

        $pix = new CelcoinPIXPayment();
        $response = $pix->emvPayment($params);

        $this->assertEquals(2, $response['type']);
    }

    private static function stubSuccess(): PromiseInterface
    {
        return Http::response(
            [
                'type' => '2',
                'collection' => '1',
                'payloadFormatIndicator' => '01',
                'merchantAccountInformation' => [
                    'url' => 'https://api-h.developer.btgpactual.com/v1/p/v2/4c98d619a4344f6aa719c35bd16fb777',
                    'gui' => 'br.gov.bcb.pix',
                    'key' => NULL,
                    'additionalInformation' => NULL,
                    'withdrawalServiceProvider' => NULL,
                ],
                'merchantCategoryCode' => 0,
                'transactionCurrency' => 986,
                'transactionAmount' => 0,
                'countryCode' => 'BR',
                'merchantName' => 'valdir sousa',
                'merchantCity' => 'barueri',
                'postalCode' => '09550001',
                'initiationMethod' => '12',
                'transactionIdentification' => '***',
            ],
            Response::HTTP_OK
        );
    }
}
