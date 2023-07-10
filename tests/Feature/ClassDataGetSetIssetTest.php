<?php

namespace Tests\Feature;

use Tests\TestCase;
use WeDevBr\Celcoin\Enums\EntityWebhookBAASEnum;
use WeDevBr\Celcoin\Types\BAAS\AccountManagerBusiness;
use WeDevBr\Celcoin\Types\BAAS\RegisterWebhooks;

class ClassDataGetSetIssetTest extends TestCase
{

    public function testSuccessGetSetData()
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
        $data->type = 'teste';

        $this->assertNotNull($data->type);
    }

    public function testSuccessToArrayWithEnum()
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

        $this->assertEquals([
            'entity' =>  EntityWebhookBAASEnum::PIX_PAYMENT_OUT->value,
            'webhookUrl' => 'http://teste.com',
            'auth' => [
                'login' => 'login_teste',
                'pwd' => 'pwd_teste',
                'type' => 'type_teste',
                "attributes" => [],
            ],
            "attributes" => [],
        ], $data->toArray());
    }

    public function testSuccessToArrayWithNullableProperty()
    {
        $data = new AccountManagerBusiness([
            "contactNumber" => 'a',
            "businessEmail" => 'b',
            "businessAddress" => [
                "postalCode" => 's',
                "street" => 't',
                "number" => 'u',
                "addressComplement" => "v",
                "neighborhood" => 'x',
                "city" => 'z',
                "state" => '1',
                "longitude" => '2',
                "latitude" => '3'
            ],
        ]);

        $this->assertEquals([
            "contactNumber" => 'a',
            "businessEmail" => 'b',
            "owners" => [],
            "businessAddress" => [
                "postalCode" => 's',
                "street" => 't',
                "number" => 'u',
                "addressComplement" => "v",
                "neighborhood" => 'x',
                "city" => 'z',
                "state" => '1',
                "longitude" => '2',
                "latitude" => '3',
                "attributes" => [],
            ],
            "attributes" => [],
        ], $data->toArray());
    }

    public function testSuccessToArray()
    {
        $data = new AccountManagerBusiness([
            "contactNumber" => 'a',
            "businessEmail" => 'b',
            "owners" => [
                [
                    "documentNumber" => 'c',
                    "phoneNumber" => 'd',
                    "email" => 'e',
                    "fullName" => 'f',
                    "socialName" => 'g',
                    "birthDate" => 'h',
                    "motherName" => 'i',
                    "address" => [
                        "postalCode" => 'j',
                        "street" => 'k',
                        "number" => 'l',
                        "addressComplement" => "m",
                        "neighborhood" => 'n',
                        "city" => 'o',
                        "state" => 'p',
                        "longitude" => 'q',
                        "latitude" => 'r'
                    ],
                    "isPoliticallyExposedPerson" => false
                ]
            ],
            "businessAddress" => [
                "postalCode" => 's',
                "street" => 't',
                "number" => 'u',
                "addressComplement" => "v",
                "neighborhood" => 'x',
                "city" => 'z',
                "state" => '1',
                "longitude" => '2',
                "latitude" => '3'
            ],
        ]);

        $this->assertEquals([
            "contactNumber" => 'a',
            "businessEmail" => 'b',
            "owners" => [
                [
                    "documentNumber" => 'c',
                    "phoneNumber" => 'd',
                    "email" => 'e',
                    "fullName" => 'f',
                    "socialName" => 'g',
                    "birthDate" => 'h',
                    "motherName" => 'i',
                    "address" => [
                        "postalCode" => 'j',
                        "street" => 'k',
                        "number" => 'l',
                        "addressComplement" => "m",
                        "neighborhood" => 'n',
                        "city" => 'o',
                        "state" => 'p',
                        "longitude" => 'q',
                        "latitude" => 'r',
                        "attributes" => [],
                    ],
                    "isPoliticallyExposedPerson" => false,
                    "attributes" => [],
                ]
            ],
            "businessAddress" => [
                "postalCode" => 's',
                "street" => 't',
                "number" => 'u',
                "addressComplement" => "v",
                "neighborhood" => 'x',
                "city" => 'z',
                "state" => '1',
                "longitude" => '2',
                "latitude" => '3',
                "attributes" => [],
            ],
            "attributes" => [],
        ], $data->toArray());
    }

    public function testSuccessAssertData()
    {
        $data = new RegisterWebhooks([
            'entity' => 'pix-payment-out',
            'webhookUrl' => 'http://teste.com',
            'auth' => [
                'login' => 'login_teste',
                'pwd' => 'pwd_teste',
                'type' => 'type_teste',
            ],
            'test' => false
        ]);

        $this->assertTrue(isset($data->test));
    }
}
