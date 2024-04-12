<?php

namespace WeDevBr\Celcoin\Tests\Integration\PIX\COB;

use GuzzleHttp\Promise\PromiseInterface;
use Illuminate\Http\Client\RequestException;
use Illuminate\Support\Facades\Http;
use Symfony\Component\HttpFoundation\Response;
use WeDevBr\Celcoin\Clients\CelcoinPIXCOB;
use WeDevBr\Celcoin\Tests\GlobalStubs;
use WeDevBr\Celcoin\Tests\TestCase;

class COBDeteleTest extends TestCase
{
    /**
     * @throws RequestException
     */
    final public function testDeleteCob(): void
    {
        $transactionId = 123456;
        Http::fake(
            [
                config('celcoin.login_url') => GlobalStubs::loginResponse(),
                sprintf(CelcoinPIXCOB::DELETE_COB_PIX_URL, $transactionId) => self::stubSuccess(),
            ],
        );
        $pixCOB = new CelcoinPIXCOB();
        $result = $pixCOB->deleteCOBPIX($transactionId);
        $this->assertEquals(200, $result['status']);
    }

    private function stubSuccess(): PromiseInterface
    {
        return Http::response(
            [
                'transactionId' => 817849688,
                'status' => 200,
                'message' => '200',
            ],
            Response::HTTP_OK,
        );
    }

    /**
     * @throws RequestException
     */
    final public function testDeleteCobNotFound(): void
    {
        $transactionId = 123456;
        Http::fake(
            [
                config('celcoin.login_url') => GlobalStubs::loginResponse(),
                sprintf(CelcoinPIXCOB::DELETE_COB_PIX_URL, $transactionId) => self::stubError(),
            ],
        );

        $this->expectException(RequestException::class);

        try {
            $pixCOB = new CelcoinPIXCOB();
            $pixCOB->deleteCOBPIX($transactionId);
        } catch (RequestException $throwable) {
            $result = $throwable->response->json();
            $this->assertEquals(Response::HTTP_NOT_FOUND, $result['statusCode']);
            $this->assertEquals(Response::HTTP_NOT_FOUND, $throwable->response->status());
            throw $throwable;
        }
    }

    private function stubError(): PromiseInterface
    {
        return Http::response(
            [
                'statusCode' => 404,
                'message' => 'Resource not found',
            ],
            Response::HTTP_NOT_FOUND,
        );
    }
}
