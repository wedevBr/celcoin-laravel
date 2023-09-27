<?php

namespace WeDevBr\Celcoin\Tests\Integration\PIX\Payments;

use GuzzleHttp\Promise\PromiseInterface;
use Illuminate\Http\Client\RequestException;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Str;
use WeDevBr\Celcoin\Clients\CelcoinPIXPayment;
use WeDevBr\Celcoin\Tests\GlobalStubs;
use WeDevBr\Celcoin\Tests\TestCase;
use WeDevBr\Celcoin\Types\PIX\PaymentInit;

class PixPaymentInitTest extends TestCase
{
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
                    CelcoinPIXPayment::INIT_PAYMENT_ENDPOINT,
                ) => self::stubSuccess(),
            ],
        );

        $params = new PaymentInit();
        $params->clientCode = Str::random();
        $params->amount = 19.12;
        $params->vlcpAmount = 19.12;
        $params->initiationType = 'MANUAL';

        $pix = new CelcoinPIXPayment();
        $response = $pix->initPayment($params);

        $this->assertArrayHasKey('endToEndId', $response);
    }

    private static function stubSuccess(): PromiseInterface
    {
        return Http::response(
            [
                'transactionId' => 45854857,
                'code' => '',
                'slip' => 'COMPROVANTE TRANSFERENCIA PIX...',
                'slipAuth' => '5C.A3.DA.5E.C2.00.27.0B.79.5F.B3.57.F2.0F.02.15',
                'endToEndId' => 'E3030629420200808185300887639654',
            ],
        );
    }
}
