<?php

namespace Tests\Integration\Assistant;

use Tests\TestCase;
use WeDevBr\Celcoin\Clients\CelcoinAssistant;

class FindInstitutionsTest extends TestCase
{

    /**
     * @return void
     */
    public function testSuccessFindInstitutions()
    {
        $assistant = new CelcoinAssistant();
        $response = $assistant->findInstitutions();

        $this->assertNotEmpty($response);
    }
}
