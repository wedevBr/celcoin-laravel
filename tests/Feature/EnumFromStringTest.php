<?php

namespace Tests\Feature;

use Tests\TestCase;
use WeDevBr\Celcoin\Enums\EntityWebhookBAASEnum;
use WeDevBr\Celcoin\Types\BAAS\RegisterWebhooks;

class EnumFromStringTest extends TestCase
{

    /**
     * @return void
     */
    public function testSuccessInstanceCreateRegisterWebhooksWithEnumString()
    {
        $data = new RegisterWebhooks([
            'entity' => 'pix-payment-out',
            'webhookUrl' => 'http://teste.com',
            'auth' => [
                'login' => 'login_teste',
                'pwd' => 'pwd_teste',
                'type' => 'type_teste',
            ]
        ]);

        $this->assertInstanceOf(EntityWebhookBAASEnum::class, $data->entity);
    }
}
