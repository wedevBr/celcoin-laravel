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

class PixGetStaticPaymentTransactionTest extends TestCase
{

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

    /**
     * @return void
     * @throws RequestException
     */
    final public function testSuccess(): void
    {
        $transactionId = 12731081;
        $url = sprintf(CelcoinPixStaticPayment::GET_STATIC_PAYMENT_ENDPOINT, $transactionId);
        Http::fake(
            [
                config('celcoin.login_url') => GlobalStubs::loginResponse(),
                sprintf(
                    '%s%s',
                    config('api_url'),
                    $url,
                ) => self::stubSuccess(),
            ],
        );

        $pix = new CelcoinPixStaticPayment();
        $response = $pix->getStaticPix($transactionId);

        $this->assertArrayHasKey('merchantAccountInformation', $response);
        $this->assertArrayHasKey('merchantCategoryCode', $response);
        $this->assertArrayHasKey('transactionCurrency', $response);
        $this->assertArrayHasKey('transactionAmount', $response);
        $this->assertArrayHasKey('countryCode', $response);
        $this->assertArrayHasKey('merchantName', $response);
        $this->assertArrayHasKey('postalCode', $response);
        $this->assertArrayHasKey('emvqrcps', $response);
    }

    /**
     * @return PromiseInterface
     */
    static private function stubSuccess(): PromiseInterface
    {
        return Http::response(
            [
                "merchantAccountInformation" => [
                    "key" => "testepix@celcoin.com.br",
                    "additionalInformation" => null,
                ],
                "merchantCategoryCode" => 0,
                "transactionCurrency" => 986,
                "transactionAmount" => 0,
                "countryCode" => "BR",
                "merchantName" => "Celcoin",
                "postalCode" => "01201005",
                "emvqrcps" => "00020126450014br.gov.bcb.pix0123testepix@celcoin.com.br5204000053039865802BR5907Celcoin6007Barueri61080120100562070503***6304FD53",
            ],
            Response::HTTP_OK,
        );
    }

    /**
     * @param Closure $response
     * @param string $status
     *
     * @return void
     * @dataProvider errorDataProvider
     * @throws RequestException
     */
    final public function testErrors(Closure $response, mixed $status): void
    {
        $transactionId = 12731081;
        $url = sprintf(CelcoinPixStaticPayment::GET_STATIC_PAYMENT_ENDPOINT, $transactionId);

        Http::fake(
            [
                config('celcoin.login_url') => GlobalStubs::loginResponse(),
                sprintf(
                    '%s%s',
                    config('api_url'),
                    $url,
                ) => $response,
            ],
        );

        $this->expectException(RequestException::class);
        try {
            $pix = new CelcoinPixStaticPayment();
            $pix->getStaticPix($transactionId);
        } catch (RequestException $exception) {
            $this->assertEquals($status, $exception->getCode());
            throw $exception;
        }
    }

    /**
     * @return array[]
     */
    private function errorDataProvider(): array
    {
        return [
            'status·code·500' => [
                fn() => Http::response([], Response::HTTP_INTERNAL_SERVER_ERROR),
                Response::HTTP_INTERNAL_SERVER_ERROR,
            ],
        ];
    }
}
