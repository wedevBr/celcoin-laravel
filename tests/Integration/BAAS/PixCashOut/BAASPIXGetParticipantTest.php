<?php

namespace WeDevBr\Celcoin\Tests\Integration\BAAS\PixCashOut;

use GuzzleHttp\Promise\PromiseInterface;
use Illuminate\Support\Facades\Http;
use Symfony\Component\HttpFoundation\Response;
use WeDevBr\Celcoin\Clients\CelcoinBAASPIX;
use WeDevBr\Celcoin\Tests\GlobalStubs;
use WeDevBr\Celcoin\Tests\TestCase;

class BAASPIXGetParticipantTest extends TestCase
{

    final public function testSuccess(): void
    {
        Http::fake(
            [
                config('celcoin.login_url') => GlobalStubs::loginResponse(),
                sprintf(
                    '%s%s*',
                    config('api_url'),
                    CelcoinBAASPIX::GET_PARTICIPANT_ENDPOINT,
                ) => self::stubSuccess(),
            ],
        );

        $pix = new CelcoinBAASPIX();
        $response = $pix->getParticipant('25683434', null);

        $this->assertCount(1, $response);
    }

    static private function stubSuccess(): PromiseInterface
    {
        return Http::response(
            [
                [
                    "date" => "2022-03-23T00:00:00",
                    "type" => "IDRT",
                    "name" => "COOPERATIVA CENTRAL DE CRÉDITO DE MINAS GERAIS LTDA. - SICOOB CENTRAL CREDIMINAS",
                    "startOperationDatetime" => "2020-11-03T09:30:00+00:00",
                    "ispb" => "25683434",
                ],
            ],
            Response::HTTP_OK,
        );
    }
}
