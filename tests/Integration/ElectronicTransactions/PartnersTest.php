<?php

namespace Tests\Integration\ElectronicTransactions;

use Tests\GlobalStubs;
use Tests\TestCase;
use WeDevBr\Celcoin\Clients\CelcoinElectronicTransactions;

class PartnersTest extends TestCase
{

    /**
     * @return void
     */
    public function testSuccessAccountCheck()
    {
        Http::fake(
            [
                config('celcoin.login_url') => GlobalStubs::loginResponse(),
                sprintf(
                    '%s%s',
                    config('api_url'),
                    sprintf(CelcoinElectronicTransactions::UPDATE_ACCOUNT_NATURAL_PERSON, '444444', '34335125070')
                ) => self::stubSuccess()
            ]
        );

        $baas = new CelcoinElectronicTransactions();
        $response = $baas->getPartners();

        $this->assertNotEmpty($response);
    }
}
