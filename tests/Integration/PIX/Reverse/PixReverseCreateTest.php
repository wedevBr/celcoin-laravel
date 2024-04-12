<?php

namespace WeDevBr\Celcoin\Tests\Integration\PIX\Reverse;

use GuzzleHttp\Promise\PromiseInterface;
use Illuminate\Http\Client\RequestException;
use Illuminate\Support\Facades\Http;
use Symfony\Component\HttpFoundation\Response;
use WeDevBr\Celcoin\Clients as Clients;
use WeDevBr\Celcoin\Tests\GlobalStubs;
use WeDevBr\Celcoin\Tests\TestCase;
use WeDevBr\Celcoin\Types\PIX as Types;

class PixReverseCreateTest extends TestCase
{
    /**
     * @throws RequestException
     */
    final public function testReverseCreateSuccess(): void
    {
        $params = new Types\PixReverseCreate();
        $params->clientCode = '123456';
        $params->amount = 15.12;
        $params->reason = 'BE08';

        $transactionId = '1234-5678';

        $url = sprintf(
            Clients\CelcoinPIXReverse::PIX_REVERSE_CREATE_ENDPOINT,
            $transactionId,
        );
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

        $pix = new Clients\CelcoinPIXReverse();
        $response = $pix->create($transactionId, $params);
        $this->assertEquals(200, $response['status']);
    }

    private static function stubSuccess(): PromiseInterface
    {
        return Http::response(
            [
                'status' => 200,
                'transactionId' => 817847550,
                'amount' => 10,
                'message' => 'PROCESSING',
            ],
            Response::HTTP_OK,
        );
    }
}
