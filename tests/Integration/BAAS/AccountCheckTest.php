<?php

namespace Tests\Integration\BAAS;

use Tests\TestCase;
use WeDevBr\Celcoin\Clients\CelcoinBAAS;

class AccountCheckTest extends TestCase
{

    /**
     * @return void
     */
    public function testSuccessAccountCheck()
    {
        $baas = new CelcoinBAAS();
        $baas->accountCheck('123456');

        $this->assertTrue($baas instanceof CelcoinBAAS);
    }
}
