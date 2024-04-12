<?php

namespace WeDevBr\Celcoin\Tests\Integration\ElectronicTransactions;

use GuzzleHttp\Promise\PromiseInterface;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Http;
use WeDevBr\Celcoin\Clients\CelcoinElectronicTransactions;
use WeDevBr\Celcoin\Tests\GlobalStubs;
use WeDevBr\Celcoin\Tests\TestCase;

class PartnersTest extends TestCase
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
                    '%s%s',
                    config('api_url'),
                    CelcoinElectronicTransactions::GET_PARTNERS_ENDPOINT,
                ) => self::stubSuccess(),
            ],
        );

        $electronicTransaction = new CelcoinElectronicTransactions();
        $response = $electronicTransaction->getPartners();

        $this->assertEquals(0, $response['status']);
    }

    private static function stubSuccess(): PromiseInterface
    {
        return Http::response(
            [
                'ParceirosPecRec' => [
                    [
                        'codeParceiro' => '0001',
                        'IndBarCodeDeposit' => 'S',
                        'IndBarCodeWithdraw' => 'S',
                        'IndQRCodeDeposit' => 'S',
                        'IndQRCodeWithdraw' => 'S',
                        'namePartner' => 'BrinksPay',
                        'partnerPecRecRecId' => '1',
                        'partnerType' => 'VAREJO',
                        'typeTransactionsCancelamento' => 'SOLICITACANCELAMENTOPECREC',
                        'maxValueDeposito' => 2000.0,
                        'maxValueSaque' => 2000.0,
                        'minValueDeposito' => 0.0,
                        'minValueSaque' => 0.01,
                    ],
                ],
                'errorCode' => '000',
                'message' => 'SUCESSO',
                'status' => 0,
            ],
            Response::HTTP_OK,
        );
    }
}
