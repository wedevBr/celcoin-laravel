<?php

namespace Tests\Integration\BAAS;

use Tests\TestCase;
use WeDevBr\Celcoin\Clients\CelcoinBAASWebhooks;
use WeDevBr\Celcoin\Enums\EntityWebhookBAASEnum;

class ListWebhooksTest extends TestCase
{

    /**
     * @return void
     */
    public function testSuccessCreate()
    {
        $baasWebhook = new CelcoinBAASWebhooks();
        $response = $baasWebhook->list(EntityWebhookBAASEnum::SPB_REVERSAL_OUT_TED, true);

        $this->assertEquals('SUCCESS', $response['status']);
    }
}
