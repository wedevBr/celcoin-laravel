<?php

namespace WeDevBr\Celcoin\Tests\Integration\BAAS;

use Carbon\Carbon;
use Illuminate\Support\Facades\Http;
use WeDevBr\Celcoin\Clients\CelcoinBAAS;
use WeDevBr\Celcoin\Tests\GlobalStubs;
use WeDevBr\Celcoin\Tests\TestCase;

class IncomeReportTest extends TestCase
{
    public function testSuccess()
    {
        Http::fake(
            [
                config('celcoin.login_url') => GlobalStubs::loginResponse(),
                sprintf(
                    '%s%s',
                    config('api_url'),
                    sprintf(CelcoinBAAS::INCOME_REPORT, '300541976902', '2024'),
                ) => self::stubSuccess(),
            ],
        );

        $baas = new CelcoinBAAS();
        $response = $baas->getIncomeReport('300541976902', Carbon::parse('2024'));

        $this->assertEquals('SUCCESS', $response['status']);
    }

    public static function stubSuccess(): array
    {
        return [
            'version' => '1.0.0',
            'status' => 'SUCCESS',
            'body' => [
                'payerSource' => [
                    'name' => 'Celcoin Teste S/A',
                    'documentNumber' => '123456',
                ],
                'owner' => [
                    'documentNumber' => '01234567890',
                    'name' => 'Nome Completo',
                    'type' => 'NATURAL_PERSON',
                    'createDate' => '15-07-1986',
                ],
                'account' => [
                    'branch' => '1234',
                    'account' => '123456',
                ],
                'balances' => [
                    [
                        'calendarYear' => '2025',
                        'amount' => 10.5,
                        'currency' => 'BRL',
                        'type' => 'SALDO',
                    ],
                ],
                'incomeFile' => 'string',
                'fileType' => 'string',
            ],
        ];
    }
}
