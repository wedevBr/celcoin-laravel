<?php

namespace Tests\Integration\BAAS;

use Tests\TestCase;
use WeDevBr\Celcoin\Clients\CelcoinBAASWebhooks;
use WeDevBr\Celcoin\Types\BAAS\RegisterWebhooks;

class RegisterWebhooksTest extends TestCase
{

    /**
     * @return void
     */
    public function testSuccessCreate()
    {
        $webhook = new RegisterWebhooks([
            'entity' => 'pix-payment-out',
            'webhookUrl' => 'http://teste.com'
        ]);


        $baasWebhook = new CelcoinBAASWebhooks();
        $baasWebhook->register($webhook);

        // ,
        //     'auth' => [
        //         'login' => 'login_teste',
        //         'pwd' => 'pwd_teste',
        //         'type' => 'type_teste',
        //     ]

        $this->assertEquals('SUCCESS', $webhook['status']);
    }
}
