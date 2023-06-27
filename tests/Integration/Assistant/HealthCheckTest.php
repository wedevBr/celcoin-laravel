<?php

namespace Tests\Integration\Assistant;

use Tests\TestCase;
use WeDevBr\Celcoin\Clients\CelcoinAssistant;
use WeDevBr\Celcoin\Enums\HealthCheckPeriodEnum;
use WeDevBr\Celcoin\Enums\HealthCheckTypeEnum;

class HealthCheckTest extends TestCase
{

    /**
     * @return void
     */
    public function testSuccessHealthCheckTest()
    {
        $assistant = new CelcoinAssistant();
        $response = $assistant->healthCheck(HealthCheckTypeEnum::ACCOUNT_DATA_QUERY, HealthCheckPeriodEnum::LAST_24_HOURS);

        $this->assertNotEmpty($response);
    }
}
