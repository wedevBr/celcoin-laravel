<?php

namespace Tests\Integration\BAAS;

use GuzzleHttp\Promise\PromiseInterface;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Http;
use Tests\GlobalStubs;
use Tests\TestCase;
use WeDevBr\Celcoin\Clients\CelcoinBAAS;
use WeDevBr\Celcoin\Types\BAAS\AccountManagerNaturalPerson;

class UpdateAccountNaturalPersonTest extends TestCase
{

    /**
     * @return void
     */
    public function testSuccess()
    {
        $fake = fake('pt_BR');
        Http::fake(
            [
                config('celcoin.login_url') => GlobalStubs::loginResponse(),
                sprintf(
                    '%s%s',
                    config('api_url'),
                    sprintf(CelcoinBAAS::UPDATE_ACCOUNT_NATURAL_PERSON, '444444', '34335125070')
                ) => self::stubSuccess()
            ]
        );

        $baas = new CelcoinBAAS();

        $firstName = $fake->firstName();

        $response = $baas->updateAccountNaturalPerson('444444', '34335125070', new AccountManagerNaturalPerson(
            [
                "phoneNumber" => sprintf('+5511%s', $fake->cellphone(false)),
                "email" => $fake->email(),
                "socialName" => $firstName,
                "birthDate" => '15-01-1981',
                "address" => [
                    "postalCode" => '01153000',
                    "street" => $fake->streetName(),
                    "number" => $fake->buildingNumber(),
                    "addressComplement" => "Em frente ao parque.",
                    "neighborhood" => 'Centro',
                    "city" => $fake->city(),
                    "state" => $fake->stateAbbr(),
                    "longitude" => $fake->longitude(-23, -24),
                    "latitude" => $fake->latitude(-46, -47)
                ],
                "isPoliticallyExposedPerson" => false
            ]
        ));

        $this->assertEquals('SUCCESS', $response['status']);
    }

    static private function stubSuccess(): PromiseInterface
    {
        return Http::response(
            [
                "version" => "1.0.0",
                "status" => "SUCCESS"
            ],
            Response::HTTP_OK
        );
    }
}
