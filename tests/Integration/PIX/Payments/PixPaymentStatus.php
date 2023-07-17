<?php

namespace Tests\Integration\PIX\Payments;

use Closure;
use GuzzleHttp\Promise\PromiseInterface;
use Illuminate\Http\Client\RequestException;
use Illuminate\Support\Facades\Http;
use Tests\GlobalStubs;
use Tests\TestCase;
use WeDevBr\Celcoin\Clients\CelcoinPIXPayment;
use WeDevBr\Celcoin\Types\PIX\PaymentStatus;

class PixPaymentStatus extends TestCase
{
    /**
     * @throws RequestException
     * @dataProvider stubSuccessStatuses
     */
    final public function testStatusSuccess(string $status, Closure $response): void
    {
        $params = new PaymentStatus();
        $params->transactionId = '123';

        $url = sprintf(
            '%s?%s',
            CelcoinPIXPayment::STATUS_PAYMENT_ENDPOINT,
            http_build_query($params)
        );

        Http::fake(
            [
                config('celcoin.login_url') => GlobalStubs::loginResponse(),
                sprintf(
                    '%s%s',
                    config('api_url'),
                    $url
                ) => $response()
            ]
        );

        $params = new PaymentStatus();
        $params->transactionId = '123';

        $pix = new CelcoinPIXPayment();
        $result = $pix->statusPayment($params);

        $this->assertEquals($status, $result['status']);
    }

    private function stubSuccessStatuses(): array
    {
        return [
            'PROCESSING' => ['PROCESSING', fn() => self::stubSuccess('PROCESSING')],
            'CONFIRMED' => ['CONFIRMED', fn() => self::stubSuccess('CONFIRMED')],
            'ERROR' => ['ERROR', fn() => self::stubSuccess('ERROR')],
        ];
    }

    private static function stubSuccess(string $status): PromiseInterface
    {
        $body = [
            'transactionId' => 9193070,
            'clientCode' => '312312312',
            'endToEndId' => 'E1393589320220322182401415343541',
            'status' => 'ERROR',
            'error' => [
                'code' => 'PBE343',
                'description' => 'Settlement of the transaction has failed.',
            ],
        ];

        return Http::response(
            array_merge($body, ['status' => $status])
        );
    }
}
