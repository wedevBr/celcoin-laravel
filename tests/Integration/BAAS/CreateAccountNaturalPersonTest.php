<?php

namespace WeDevBr\Celcoin\Tests\Integration\BAAS;

use GuzzleHttp\Promise\PromiseInterface;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Http;
use WeDevBr\Celcoin\Clients\CelcoinBAAS;
use WeDevBr\Celcoin\Enums\AccountOnboardingTypeEnum;
use WeDevBr\Celcoin\Tests\GlobalStubs;
use WeDevBr\Celcoin\Tests\TestCase;
use WeDevBr\Celcoin\Types\BAAS\AccountNaturalPerson;

class CreateAccountNaturalPersonTest extends TestCase
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
                    CelcoinBAAS::CREATE_ACCOUNT_NATURAL_PERSON,
                ) => self::stubSuccess(),
            ],
        );

        $baas = new CelcoinBAAS();

        $firstName = $fake->firstName();
        $lastName = $fake->lastName();

        $response = $baas->createAccountNaturalPerson(
            new AccountNaturalPerson(
                [
                    'clientCode' => $fake->uuid(),
                    'accountOnboardingType' => AccountOnboardingTypeEnum::BANK_ACCOUNT,
                    'documentNumber' => $fake->cpf(false),
                    'phoneNumber' => sprintf('+5511%s', $fake->cellphone(false)),
                    'email' => $fake->email(),
                    'motherName' => sprintf('%s %s', $fake->firstNameFemale(), $fake->lastName()),
                    'fullName' => sprintf('%s %s', $firstName, $lastName),
                    'socialName' => $firstName,
                    'birthDate' => '15-01-1981',
                    'address' => [
                        'postalCode' => '01153000',
                        'street' => $fake->streetName(),
                        'number' => $fake->buildingNumber(),
                        'addressComplement' => 'Em frente ao parque.',
                        'neighborhood' => 'Centro',
                        'city' => $fake->city(),
                        'state' => $fake->stateAbbr(),
                        'longitude' => $fake->longitude(-23, -24),
                        'latitude' => $fake->latitude(-46, -47),
                    ],
                    'isPoliticallyExposedPerson' => false,
                ],
            ),
        );

        $this->assertEquals('PROCESSING', $response['status']);
    }

    private static function stubSuccess(): PromiseInterface
    {
        return Http::response(
            [
                'version' => '1.0.0',
                'status' => 'PROCESSING',
                'body' => [
                    'onBoardingId' => '39c8e322-9192-498d-947e-2daa4dfc749e',
                ],
            ],
            Response::HTTP_OK,
        );
    }
}
