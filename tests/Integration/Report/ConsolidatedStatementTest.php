<?php

namespace WeDevBr\Celcoin\Tests\Integration\Report;

use Carbon\Carbon;
use GuzzleHttp\Promise\PromiseInterface;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Http;
use WeDevBr\Celcoin\Clients\CelcoinReport;
use WeDevBr\Celcoin\Tests\GlobalStubs;
use WeDevBr\Celcoin\Tests\TestCase;

class ConsolidatedStatementTest extends TestCase
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
                    CelcoinReport::CONSOLIDATED_STATEMENT_ENDPOINT,
                ) => self::stubSuccess(),
            ],
        );

        $report = new CelcoinReport();
        $response = $report->consolidatedStatement(Carbon::now()->subDays(1), Carbon::now());
        $this->assertArrayHasKey('statement', $response);
    }

    static private function stubSuccess(): PromiseInterface
    {
        return Http::response(
            [
                "statement" => [
                    [
                        "date" => "2022-01-03T00:00:00",
                        "accountDate" => "2022-01-03T00:00:00",
                        "nsa" => 5729,
                        "entryName" => "Pgto Contas Concessionarias/Tributos",
                        "entryAmount" => 47887,
                        "value" => -4212076.5,
                        "indCreditDebit" => "D",
                        "balance" => -1802424.5,
                    ],
                    [
                        "date" => "2022-01-03T00:00:00",
                        "accountDate" => "2022-01-03T00:00:00",
                        "nsa" => 5729,
                        "entryName" => "Pgto Contas Boletos",
                        "entryAmount" => 204577,
                        "value" => -24533722,
                        "indCreditDebit" => "D",
                        "balance" => -26336146,
                    ],
                    [
                        "date" => "2022-01-03T00:00:00",
                        "accountDate" => "2022-01-03T00:00:00",
                        "nsa" => 5729,
                        "entryName" => "Recarga",
                        "entryAmount" => 103422,
                        "value" => -1746272.9,
                        "indCreditDebit" => "D",
                        "balance" => -28082420,
                    ],
                    [
                        "date" => "2022-01-03T00:00:00",
                        "accountDate" => "2022-01-03T00:00:00",
                        "entryName" => "Depósito",
                        "entryAmount" => 20,
                        "value" => 12520000,
                        "indCreditDebit" => "C",
                        "balance" => -22277410,
                    ],
                    [
                        "date" => "2022-01-03T00:00:00",
                        "accountDate" => "2022-01-03T00:00:00",
                        "entryName" => "Estorno de Contas",
                        "entryAmount" => 113,
                        "value" => 4824.52,
                        "indCreditDebit" => "C",
                        "balance" => -22272586,
                    ],
                    [
                        "date" => "2022-01-03T00:00:00",
                        "accountDate" => "2022-01-03T00:00:00",
                        "entryName" => "Estorno de Conta - Desfazimento",
                        "entryAmount" => 1,
                        "value" => 55,
                        "indCreditDebit" => "C",
                        "balance" => -22272530,
                    ],
                    [
                        "date" => "2022-01-03T00:00:00",
                        "accountDate" => "2022-01-03T00:00:00",
                        "entryName" => "Devolução Transferencias",
                        "entryAmount" => 69,
                        "value" => 19452.8,
                        "indCreditDebit" => "C",
                        "balance" => -22253078,
                    ],
                    [
                        "date" => "2022-01-03T00:00:00",
                        "accountDate" => "2022-01-03T00:00:00",
                        "entryName" => "Transferencias",
                        "entryAmount" => 775,
                        "value" => -292824.75,
                        "indCreditDebit" => "D",
                        "balance" => -28375244,
                    ],
                    [
                        "date" => "2022-01-03T00:00:00",
                        "accountDate" => "2022-01-03T00:00:00",
                        "entryName" => "Pagamento Eletronico",
                        "entryAmount" => 345,
                        "value" => 268750,
                        "indCreditDebit" => "C",
                        "balance" => -21984328,
                    ],
                    [
                        "date" => "2022-01-03T00:00:00",
                        "accountDate" => "2022-01-03T00:00:00",
                        "entryName" => "Recebimento Eletronico",
                        "entryAmount" => 7,
                        "value" => -920,
                        "indCreditDebit" => "D",
                        "balance" => -28376164,
                    ],
                ],
                "balance" => [
                    "balanceStartDate" => 2409652.2,
                    "balanceEndDate" => -210270.39,
                ],
                "pagination" => [
                    "page" => 1,
                    "totalCount" => 16,
                    "totalPages" => 2,
                    "hasPrevious" => false,
                    "hasNext" => true,
                ],
            ],
            Response::HTTP_OK,
        );
    }
}
