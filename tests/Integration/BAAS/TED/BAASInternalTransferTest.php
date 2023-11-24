<?php

namespace WeDevBr\Celcoin\Tests\Integration\BAAS\TED;

use GuzzleHttp\Promise\PromiseInterface;
use Illuminate\Support\Facades\Http;
use Symfony\Component\HttpFoundation\Response;
use WeDevBr\Celcoin\Clients\CelcoinBAASTED;
use WeDevBr\Celcoin\Tests\GlobalStubs;
use WeDevBr\Celcoin\Tests\TestCase;
use WeDevBr\Celcoin\Types\BAAS\TEFTransfer;

class BAASInternalTransferTest extends TestCase
{
    public function testSendSuccess()
    {
        Http::fake(
            [
                config('celcoin.login_url') => GlobalStubs::loginResponse(),
                sprintf(
                    '%s%s',
                    config('api_url'),
                    CelcoinBAASTED::INTERNAL_TRANSFER_ENDPOINT,
                ) => self::stubSuccess(),
            ],
        );

        $ted = new CelcoinBAASTED();

        $response = $ted->internalTransfer(
            new TEFTransfer([
                "amount" => 4.00,
                "clientRequestId" => "1234",
                "debitParty" => [
                    "account" => "300541976902",
                ],
                "creditParty" => [
                    "account" => "300541976910",
                ],
                "description" => "transferencia para o churrasco",
            ]),
        );

        $this->assertEquals('PROCESSING', $response['status']);
    }

    public function testGetTransaction()
    {
        Http::fake(
            [
                config('celcoin.login_url') => GlobalStubs::loginResponse(),
                sprintf(
                    '%s%s',
                    config('api_url'),
                    CelcoinBAASTED::GET_STATUS_INTERNAL_TRANSFER_ENDPOINT . '?Id=222dbad8-c309-4f52-af62-8bfbe945ca2d',
                ) => self::stubSuccess(),
            ],
        );

        $ted = new CelcoinBAASTED();
        $response = $ted->getStatusInternalTransfer('222dbad8-c309-4f52-af62-8bfbe945ca2d');
        $this->assertEquals('PROCESSING', $response['status']);
        $this->assertEquals('222dbad8-c309-4f52-af62-8bfbe945ca2d', $response['body']['id']);
    }

    static private function stubSuccess(): PromiseInterface
    {
        return Http::response(
            [
                "status" => "PROCESSING",
                "version" => "1.0.0",
                "body" => [
                    "id" => "222dbad8-c309-4f52-af62-8bfbe945ca2d",
                    "amount" => 4,
                    "clientRequestId" => "1234",
                    "endToEndId" => "string",
                    "debitParty" => [
                        "account" => "300541976902",
                        "branch" => "0001",
                        "taxId" => "09876543210",
                        "name" => "Mateus",
                        "bank" => "13935893",
                    ],
                    "creditParty" => [
                        "bank" => "30306294",
                        "account" => "300541976910",
                        "branch" => "0001",
                        "taxId" => "01234567890",
                        "name" => "Noelí Valência",
                    ],
                    "description" => "transferencia para o churrasco",
                ],
            ],
            Response::HTTP_OK,
        );
    }
}