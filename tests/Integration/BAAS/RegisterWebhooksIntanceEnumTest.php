<?php

namespace Tests\Integration\BAAS;

use Tests\TestCase;
use WeDevBr\Celcoin\Enums\EntityWebhookBAASEnum;
use WeDevBr\Celcoin\Types\BAAS\RegisterWebhooks;

class RegisterWebhooksIntanceEnumTest extends TestCase
{

    /**
     * @return void
     */
    public function testSuccessInstanceCreateRegisterWebhooksWithEnumString()
    {
        $webhook = new RegisterWebhooks([
            'entity' => 'pix-payment-out',
            'webhookUrl' => 'http://teste.com',
            'auth' => [
                'login' => 'login_teste',
                'pwd' => 'pwd_teste',
                'type' => 'type_teste',
            ]
        ]);

        $this->assertTrue($webhook->entity instanceof EntityWebhookBAASEnum);
    }
}
