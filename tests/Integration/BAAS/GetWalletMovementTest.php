<?php

namespace WeDevBr\Celcoin\Tests\Integration\BAAS;

use Carbon\Carbon;
use GuzzleHttp\Promise\PromiseInterface;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Http;
use WeDevBr\Celcoin\Clients\CelcoinBAAS;
use WeDevBr\Celcoin\Tests\GlobalStubs;
use WeDevBr\Celcoin\Tests\TestCase;

class GetWalletMovementTest extends TestCase
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
                    CelcoinBAAS::GET_WALLET_MOVEMENT,
                ) => self::stubSuccess(),
            ],
        );
        $baasWebhook = new CelcoinBAAS();
        $response = $baasWebhook->getWalletMovement(
            '300541976902',
            '17938715000192',
            Carbon::createFromFormat('Y-m-d', '2023-07-17'),
            Carbon::createFromFormat('Y-m-d', '2023-07-17'),
        );

        $this->assertEquals('SUCCESS', $response['status']);
    }

    private static function stubSuccess(): PromiseInterface
    {
        return Http::response(
            [
                'status' => 'SUCCESS',
                'version' => '1.0.0',
                'totalItems' => 200,
                'currentPage' => 1,
                'totalPages' => 10,
                'dateFrom' => '2022-01-01',
                'dateTo' => '2022-01-02',
                'body' => [
                    'account' => '300151',
                    'documentNumber' => '34335125070',
                    'movements' => [
                        [
                            'id' => 'aa99877c-6205-45ce-8fd8-18173fdd782a',
                            'clientCode' => '7a2a4ea2-ee65-4b3d-8e1d-311dd45d3017',
                            'description' => 'Recebimento Pix',
                            'createDate' => '2022-08-31T17:19:55',
                            'lastUpdateDate' => '2022-08-31T17:19:55',
                            'amount' => 10.12,
                            'status' => 'Saldo Liberado',
                            'balanceType' => 'CREDIT',
                            'movementType' => 'PIXPAYMENTIN',
                        ],
                    ],
                ],
            ],
            Response::HTTP_OK,
        );
    }
}
