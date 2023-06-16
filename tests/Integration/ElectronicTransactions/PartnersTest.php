<?php

namespace Tests\Integration\BAAS;

use Tests\TestCase;
use WeDevBr\Celcoin\Clients\CelcoinElectronicTransactions;

class PartnersTest extends TestCase
{

    /**
     * @return void
     */
    public function testSuccessAccountCheck()
    {
        $baas = new CelcoinElectronicTransactions();
        $response = $baas->getPartners();

        $this->assertNotEmpty($response);
    }
}
