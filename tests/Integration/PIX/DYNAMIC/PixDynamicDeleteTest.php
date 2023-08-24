<?php

namespace WeDevBr\Celcoin\Tests\Integration\PIX\DYNAMIC;

use GuzzleHttp\Promise\PromiseInterface;
use Illuminate\Http\Client\RequestException;
use Illuminate\Support\Facades\Http;
use Symfony\Component\HttpFoundation\Response;
use WeDevBr\Celcoin\Clients\CelcoinPIXDynamic;
use WeDevBr\Celcoin\Tests\GlobalStubs;
use WeDevBr\Celcoin\Tests\TestCase;

class PixDynamicDeleteTest extends TestCase
{

    /**
     * @return void
     * @throws RequestException
     */
    final public function testDynamicPixDeleteSuccess(): void
    {
        $transactionId = 123456;
        Http::fake(
            [
                config('celcoin.login_url') => GlobalStubs::loginResponse(),
                sprintf(CelcoinPIXDynamic::DELETE_DYNAMIC_QRCODE_ENDPOINT, $transactionId) => self::stubSuccess(),
            ],
        );
        $pixCOB = new CelcoinPIXDynamic();
        $result = $pixCOB->deleteDynamicQRCode($transactionId);
        $this->assertEquals(Response::HTTP_OK, $result['status']);
    }

    private static function stubSuccess(): PromiseInterface
    {
        return Http::response(
            [
                'transactionId' => 9194708,
                'status' => 200,
                'message' => 'Sucesso',
            ],
            Response::HTTP_OK,
        );
    }

    /**
     * @return void
     * @throws RequestException
     */
    final public function testDynamicPixDeleteNotFoundError(): void
    {
        $transactionId = 123456;
        Http::fake(
            [
                config('celcoin.login_url') => GlobalStubs::loginResponse(),
                sprintf(CelcoinPIXDynamic::DELETE_DYNAMIC_QRCODE_ENDPOINT, $transactionId) => self::stubNotFoundError(),
            ],
        );
        $this->expectException(RequestException::class);
        try {
            $pixCOB = new CelcoinPIXDynamic();
            $pixCOB->deleteDynamicQRCode($transactionId);
        } catch (RequestException $exception) {
            $result = $exception->response->json();
            $this->assertEquals(Response::HTTP_NOT_FOUND, $result['errorCode']);
            throw $exception;
        }
    }

    private static function stubNotFoundError(): PromiseInterface
    {
        return Http::response(
            [
                'errorCode' => '404',
                'description' => [
                    'version' => '1.2.7',
                    'status' => 404,
                ],
            ],
            Response::HTTP_NOT_FOUND,
        );
    }
}
