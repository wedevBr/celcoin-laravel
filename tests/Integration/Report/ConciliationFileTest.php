<?php

namespace Tests\Integration\Report;

use Carbon\Carbon;
use GuzzleHttp\Promise\PromiseInterface;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Http;
use Tests\GlobalStubs;
use Tests\TestCase;
use WeDevBr\Celcoin\Clients\CelcoinReport;

class ConciliationFileTest extends TestCase
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
                    CelcoinReport::CONCILIATION_FILE_ENDPOINT
                ) => self::stubSuccess()
            ]
        );

        $report = new CelcoinReport();
        $response = $report->conciliationFile(1, Carbon::createFromFormat('Y-m-d', '2023-07-06'));
        $this->assertArrayHasKey('movement', $response);
    }

    static private function stubSuccess(): PromiseInterface
    {
        return Http::response(
            [
                "movement" => [
                    [
                        "DigitableLine" => "03399492813698211200901537301028400000000000000 ",
                        "AccountDate" => "2022-06-01T00:00:00",
                        "Value" => 304.1,
                        "TransactionType" => 1,
                        "TransactionDateTime" => "2022-06-01T20:00:00",
                        "TransactionCode" => "RECEBERCONTA",
                        "TransactionId" => 815977512,
                        "NSU" => 97102,
                        "ExternalTerminal" => "TesteMockado-6C59770F-4A0A-4429-9C39-0ADBFFCDB525",
                        "ExternalNSU" => 2105324538,
                        "PaymentMethod" => 2
                    ],
                    [
                        "DigitableLine" => "03399492813698211200901537301028400000000000000 ",
                        "AccountDate" => "2022-06-01T00:00:00",
                        "Value" => 354.7,
                        "TransactionType" => 1,
                        "TransactionDateTime" => "2022-06-01T15:00:00",
                        "TransactionCode" => "RECEBERCONTA",
                        "TransactionId" => 815977513,
                        "NSU" => 2107,
                        "ExternalTerminal" => "TesteMockado-3A977B5E-631D-4D59-8265-F780FDD3E373",
                        "ExternalNSU" => 966441828,
                        "PaymentMethod" => 2
                    ]
                ],
                "pagination" => [
                    "page" => 1,
                    "totalCount" => 10,
                    "totalPages" => 5,
                    "hasPrevious" => false,
                    "hasNext" => true
                ]
            ],
            Response::HTTP_OK
        );
    }
}
