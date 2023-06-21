<?php

namespace Tests\Integration\BAAS;

use Tests\TestCase;
use WeDevBr\Celcoin\Enums\BAASWebhookEnum;
use WeDevBr\Celcoin\Types\BAAS\RegisterWebhooks;

class CreateRegisterWebhooksTypeTest extends TestCase
{

    /**
     * @return void
     */
    public function testSuccessCreateEnum()
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

        $this->assertTrue($webhook->entity instanceof BAASWebhookEnum);
    }
}
