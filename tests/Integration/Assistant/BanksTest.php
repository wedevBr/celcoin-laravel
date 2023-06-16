<?php

namespace Tests\Integration\Assistant;

use Tests\TestCase;
use WeDevBr\Celcoin\Clients\CelcoinAssistant as CelcoinCelcoinAssistant;

class BanksTest extends TestCase
{

    /**
     * @return void
     */
    public function testSuccessBanksTest()
    {
        $assistant = new CelcoinCelcoinAssistant();
        $response = $assistant->getBanks();

        $this->assertNotEmpty($response);
    }
}
