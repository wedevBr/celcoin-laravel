<?php

namespace WeDevBr\Celcoin\Tests\Integration\BAAS\TED;

use GuzzleHttp\Promise\PromiseInterface;
use Illuminate\Support\Facades\Http;
use Symfony\Component\HttpFoundation\Response;
use WeDevBr\Celcoin\Clients\CelcoinBAASTED;
use WeDevBr\Celcoin\Tests\GlobalStubs;
use WeDevBr\Celcoin\Tests\TestCase;

class BAASTEDGetStatusTransferTest extends TestCase
{
    final public function testSuccess(): void
    {
        Http::fake(
            [
                config('celcoin.login_url') => GlobalStubs::loginResponse(),
                sprintf(
                    '%s%s*',
                    config('api_url'),
                    CelcoinBAASTED::GET_STATUS_TRANSFER_ENDPOINT,
                ) => self::stubSuccess(),
            ],
        );

        $ted = new CelcoinBAASTED();
        $response = $ted->getStatusTransfer('5e8e0e08-1628-4265-be6f-26cc23e265a4', '1234');

        $this->assertEquals('CONFIRMED', $response['status']);
    }

    private static function stubSuccess(): PromiseInterface
    {
        return Http::response(
            [
                'status' => 'CONFIRMED',
                'version' => '1.0.0',
                'body' => [
                    'id' => '34fee7bc-4d40-4605-9af8-398ed7d0d6b5',
                    'amount' => 25.55,
                    'clientCode' => '1458854',
                    'debitParty' => [
                        'account' => '444444',
                        'branch' => '1',
                        'taxId' => '11122233344',
                        'name' => 'Celcoin',
                        'accountType' => 'CACC',
                        'personType' => 'F',
                        'bank' => '30306294',
                    ],
                    'creditParty' => [
                        'bank' => '30306294',
                        'account' => '10545584',
                        'branch' => '1',
                        'taxId' => '11122233344',
                        'name' => 'Celcoin',
                        'accountType' => 'CC',
                        'personType' => 'F',
                    ],
                    'description' => 'Texto de mensagem',
                    'error' => [
                        'errorCode' => 'CIE999',
                        'message' => 'Ocorreu um erro interno durante a chamada da api.',
                    ],
                ],
            ],
            Response::HTTP_OK,
        );
    }
}
