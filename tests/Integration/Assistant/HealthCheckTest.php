<?php

namespace WeDevBr\Celcoin\Tests\Integration\Assistant;

use GuzzleHttp\Promise\PromiseInterface;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Http;
use WeDevBr\Celcoin\Clients\CelcoinAssistant;
use WeDevBr\Celcoin\Enums\HealthCheckTypeEnum;
use WeDevBr\Celcoin\Tests\GlobalStubs;
use WeDevBr\Celcoin\Tests\TestCase;

class HealthCheckTest extends TestCase
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
                    CelcoinAssistant::HEALTH_CHECK_ENDPOINT,
                ) => self::stubSuccess(),
            ],
        );

        $assistant = new CelcoinAssistant();
        $response = $assistant->healthCheck(HealthCheckTypeEnum::ACCOUNT_DATA_QUERY);
        $this->assertEquals(0, $response['status']);
    }

    static private function stubSuccess(): PromiseInterface
    {
        return Http::response(
            [
                "HealthCheck" => [
                    [
                        "kpiAvailability" => -1.0,
                        "statusKPIAvailability" => -1,
                        "statusAverageTime" => -1,
                        "averageTime" => -1.0,
                        "thresholdKPIAvailabilityDown" => 80.0,
                        "thresholdKPIAvailabilityUP" => 99.0,
                        "thresholdAverageTimeDown" => 12.0,
                        "thresholdAverageTimeUP" => 2.5,
                        "transaction" => "CONSULTADADOSCONTA",
                    ],
                ],
                "errorCode" => "000",
                "message" => "SUCESSO",
                "status" => 0,
            ],
            Response::HTTP_OK,
        );
    }
}
