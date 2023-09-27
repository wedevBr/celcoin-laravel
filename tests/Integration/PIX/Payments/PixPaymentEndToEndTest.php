<?php

namespace WeDevBr\Celcoin\Tests\Integration\PIX\Payments;

use GuzzleHttp\Promise\PromiseInterface;
use Illuminate\Http\Client\RequestException;
use Illuminate\Support\Facades\Http;
use Illuminate\Validation\ValidationException;
use Symfony\Component\HttpFoundation\Response;
use WeDevBr\Celcoin\Clients\CelcoinPIXPayment;
use WeDevBr\Celcoin\Tests\GlobalStubs;
use WeDevBr\Celcoin\Tests\TestCase;
use WeDevBr\Celcoin\Types\PIX\PaymentEndToEnd;

class PixPaymentEndToEndTest extends TestCase
{
    /**
     * @throws RequestException
     */
    final public function testGenerateEndToEndSuccess(): void
    {
        Http::fake(
            [
                config('celcoin.login_url') => GlobalStubs::loginResponse(),
                sprintf(
                    '%s%s',
                    config('api_url'),
                    CelcoinPIXPayment::END_TO_END_PAYMENT_ENDPOINT,
                ) => self::stubSuccess(),
            ],
        );

        $params = new PaymentEndToEnd();
        $params->dpp = now()->toDateString();

        $pix = new CelcoinPIXPayment();
        $response = $pix->endToEndPayment($params);

        $this->assertEquals(Response::HTTP_CREATED, $response['status']);
        $this->assertArrayHasKey('body', $response);
        $this->assertArrayHasKey('endToEndId', $response['body']);
    }

    private static function stubSuccess(): PromiseInterface
    {
        return Http::response(
            [
                'status' => 201,
                'body' => [
                    'endToEndId' => 'E3030629420200808185300887639654',
                ],
            ],
            Response::HTTP_CREATED,
        );
    }

    /**
     * @throws RequestException
     */
    final public function testGenerateEndToEndError(): void
    {
        Http::fake(
            [
                config('celcoin.login_url') => GlobalStubs::loginResponse(),
                sprintf(
                    '%s%s',
                    config('api_url'),
                    CelcoinPIXPayment::END_TO_END_PAYMENT_ENDPOINT,
                ) => self::stubSuccess(),
            ],
        );

        $params = new PaymentEndToEnd();
        $params->dpp = 'data errada';

        $this->expectException(ValidationException::class);
        try {
            $pix = new CelcoinPIXPayment();
            $pix->endToEndPayment($params);
        } catch (ValidationException $exception) {
            $erros = $exception->errors();
            $this->assertArrayHasKey('dpp', $erros);
            throw $exception;
        }
    }
}
