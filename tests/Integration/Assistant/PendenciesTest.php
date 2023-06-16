<?php

namespace Tests\Integration\Assistant;

use Tests\TestCase;
use WeDevBr\Celcoin\Clients\CelcoinAssistant;

class PendenciesTest extends TestCase
{

    /**
     * @return void
     */
    public function testSuccessPendenciesTest()
    {
        $assistant = new CelcoinAssistant();
        $response = $assistant->getPendenciesList();

        $this->assertNotEmpty($response);
    }
}
