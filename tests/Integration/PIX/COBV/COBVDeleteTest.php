<?php

namespace WeDevBr\Celcoin\Tests\Integration\PIX\COBV;

use GuzzleHttp\Promise\PromiseInterface;
use Illuminate\Http\Client\RequestException;
use Illuminate\Support\Facades\Http;
use Symfony\Component\HttpFoundation\Response;
use WeDevBr\Celcoin\Clients\CelcoinPIXCOBV;
use WeDevBr\Celcoin\Tests\GlobalStubs;
use WeDevBr\Celcoin\Tests\TestCase;

class COBVDeleteTest extends TestCase
{
    /**
     * @throws RequestException
     */
    final public function testDeleteCobvInvalidSource(): void
    {
        $transactionId = 1234;
        Http::fake(
            [
                config('celcoin.login_url') => GlobalStubs::loginResponse(),
                sprintf(CelcoinPIXCOBV::DELETE_COB_PIX_URL, $transactionId) => self::stubErrorInvalidValue(),
            ],
        );
        $this->expectException(RequestException::class);
        try {
            $pixCOB = new CelcoinPIXCOBV();
            $pixCOB->deleteCOBVPIX($transactionId);
        } catch (RequestException $exception) {
            $result = $exception->response->json();
            $this->assertEquals('DE001', $result['errorCode']);
            throw $exception;
        }
    }

    private static function stubErrorInvalidValue(): PromiseInterface
    {
        return Http::response(
            [
                'errorCode' => 'DE001',
                'description' => 'Value cannot be null. (Parameter \'source\')',
            ],
            Response::HTTP_BAD_REQUEST,
        );
    }

    /**
     * @throws RequestException
     */
    final public function testDeleteCobvSuccess(): void
    {
        $transactionId = 123456;
        Http::fake(
            [
                config('celcoin.login_url') => GlobalStubs::loginResponse(),
                sprintf(CelcoinPIXCOBV::DELETE_COB_PIX_URL, $transactionId) => self::stubSuccess(),
            ],
        );
        $pixCOB = new CelcoinPIXCOBV();
        $result = $pixCOB->deleteCOBVPIX($transactionId);
        $this->assertEquals(Response::HTTP_OK, $result['status']);
    }

    private static function stubSuccess(): PromiseInterface
    {
        return Http::response(
            [
                'transactionId' => 45854857,
                'status' => 200,
                'message' => 'success',
            ],
            Response::HTTP_OK,
        );
    }
}
