<?php

namespace WeDevBr\Celcoin\Tests\Integration\PIX\StaticPayment;

use Closure;
use GuzzleHttp\Promise\PromiseInterface;
use Illuminate\Http\Client\RequestException;
use Illuminate\Support\Facades\Http;
use Symfony\Component\HttpFoundation\Response;
use WeDevBr\Celcoin\Clients\CelcoinPixStaticPayment;
use WeDevBr\Celcoin\Tests\GlobalStubs;
use WeDevBr\Celcoin\Tests\TestCase;
use WeDevBr\Celcoin\Types\PIX\Merchant;
use WeDevBr\Celcoin\Types\PIX\QRStaticPayment;

class PixCreateStaticPaymentTest extends TestCase
{
    /**
     * @throws RequestException
     */
    final public function testCreateStaticPayment(): void
    {
        Http::fake(
            [
                config('celcoin.login_url') => GlobalStubs::loginResponse(),
                sprintf(
                    '%s%s',
                    config('api_url'),
                    CelcoinPixStaticPayment::CREATE_STATIC_PAYMENT_ENDPOINT,
                ) => self::stubSuccess(),
            ],
        );

        $paymentBody = $this->fakeQRStaticPayment();
        $payment = new CelcoinPixStaticPayment();
        $response = $payment->create($paymentBody);

        $this->assertArrayHasKey('emvqrcps', $response);
        $this->assertArrayHasKey('transactionId', $response);
        $this->assertArrayHasKey('transactionIdentification', $response);
    }

    private static function stubSuccess(): PromiseInterface
    {
        return Http::response(
            [
                'emvqrcps' => '00020126480014br.gov.bcb.pix0115aron@mqx.com.br0207adasdas520400005303986540515.605802BR5908Endereco6008Araruama61082897906362100506asdsad63040C48',
                'transactionId' => 817834704,
                'transactionIdentification' => 'asdsad',
            ],
            Response::HTTP_OK,
        );
    }

    private function fakeQRStaticPayment(): QRStaticPayment
    {
        $merchant = new Merchant();
        $merchant->postalCode = '01201005';
        $merchant->city = 'Barueri';
        $merchant->merchantCategoryCode = '0000';
        $merchant->name = 'Celcoin Pagamentos';

        $staticPayment = new QRStaticPayment();
        $staticPayment->merchant = $merchant;
        $staticPayment->key = 'chave-pix';
        $staticPayment->amount = 123.45;
        $staticPayment->additionalInformation = 'nota';
        $staticPayment->transactionIdentification = '9b26edb7cf254db09f5449c94bf13abc';
        $staticPayment->tags = [
            'tag 1',
        ];

        return $staticPayment;
    }

    /**
     * @throws RequestException
     *
     * @dataProvider errorDataProvider
     */
    final public function testConvertingValueError(Closure $response, int $status): void
    {
        Http::fake(
            [
                config('celcoin.login_url') => GlobalStubs::loginResponse(),
                sprintf(
                    '%s%s',
                    config('api_url'),
                    CelcoinPixStaticPayment::CREATE_STATIC_PAYMENT_ENDPOINT,
                ) => $response,
            ],
        );

        $this->expectException(RequestException::class);

        try {
            $paymentBody = $this->fakeQRStaticPayment();
            $payment = new CelcoinPixStaticPayment();
            $payment->create($paymentBody);
        } catch (RequestException $exception) {
            $this->assertEquals($status, $exception->getCode());
            throw $exception;
        }
    }

    /**
     * @return array[]
     */
    public static function errorDataProvider(): array
    {
        return [
            // Status 500 - Internal server error return empty array
            'status·code·500' => [
                fn () => Http::response([], Response::HTTP_INTERNAL_SERVER_ERROR),
                Response::HTTP_INTERNAL_SERVER_ERROR,
            ],
        ];
    }
}
