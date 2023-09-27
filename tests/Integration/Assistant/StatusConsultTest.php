<?php

namespace WeDevBr\Celcoin\Tests\Integration\Assistant;

use GuzzleHttp\Promise\PromiseInterface;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Http;
use WeDevBr\Celcoin\Clients\CelcoinAssistant;
use WeDevBr\Celcoin\Tests\GlobalStubs;
use WeDevBr\Celcoin\Tests\TestCase;

class StatusConsultTest extends TestCase
{
    /**
     * @return void
     */
    public function testSuccess()
    {
        Http::fake(
            [
                config('celcoin.login_url') => GlobalStubs::loginResponse(),
                sprintf(
                    '%s%s*',
                    config('api_url'),
                    CelcoinAssistant::STATUS_CONSULT_ENDPOINT,
                ) => self::stubSuccess(),
            ],
        );

        $assistant = new CelcoinAssistant();
        $response = $assistant->statusConsult(externalNSU: 1234);
        $this->assertEquals(0, $response['status']);
    }

    static private function stubSuccess(): PromiseInterface
    {
        return Http::response(
            [
                "transaction" => [
                    "authentication" => 0,
                    "errorCode" => "061",
                    "createDate" => "0001-01-01T00:00:00",
                    "message" => "Transacao nao encontrada",
                    "externalNSU" => 1234,
                    "transactionId" => 1,
                    "status" => 1,
                    "externalTerminal" => null,
                ],
                "errorCode" => "000",
                "message" => "SUCESSO",
                "status" => 0,
            ],
            Response::HTTP_OK,
        );
    }
}
