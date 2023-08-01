<?php

namespace Tests\Integration\Report;

use GuzzleHttp\Promise\PromiseInterface;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Http;
use Tests\GlobalStubs;
use Tests\TestCase;
use WeDevBr\Celcoin\Clients\CelcoinReport;

class ConciliationFileTypesTest extends TestCase
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
                    CelcoinReport::GET_CONCILIATION_FILE_TYPES_ENDPOINT
                ) => self::stubSuccess()
            ]
        );

        $report = new CelcoinReport();
        $response = $report->getConciliationFileTypes();
        $this->assertIsArray($response);
    }

    static private function stubSuccess(): PromiseInterface
    {
        return Http::response(
            [
                [
                    "fileType" => 1,
                    "description" => "Movimentacao"
                ],
                [
                    "fileType" => 2,
                    "description" => "Recusa Movimentacao"
                ],
                [
                    "fileType" => 22,
                    "description" => "Transferencia Movimentacao"
                ],
                [
                    "fileType" => 23,
                    "description" => "Transferencia Recusa"
                ],
                [
                    "fileType" => 24,
                    "description" => "Recebimento Eletronico"
                ],
                [
                    "fileType" => 25,
                    "description" => "Pagamento Eletronico"
                ],
                [
                    "fileType" => 36,
                    "description" => "PIX Pagamento"
                ],
                [
                    "fileType" => 37,
                    "description" => "PIX Recebimento"
                ],
                [
                    "fileType" => 38,
                    "description" => "PIX Devolução de Recebimento"
                ],
                [
                    "fileType" => 39,
                    "description" => "PIX Devolução de Pagamento"
                ],
                [
                    "fileType" => 40,
                    "description" => "Recarga Internacional"
                ],
                [
                    "fileType" => 41,
                    "description" => "PIX Aporte"
                ],
                [
                    "fileType" => 43,
                    "description" => "Pagamento DA"
                ],
                [
                    "fileType" => 46,
                    "description" => "Consulta Debito Veicular"
                ],
                [
                    "fileType" => 47,
                    "description" => "Liquidacao Debito Veicular"
                ]
            ],
            Response::HTTP_OK
        );
    }
}
