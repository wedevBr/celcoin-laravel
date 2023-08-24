<?php

namespace WeDevBr\Celcoin\Tests\Integration\BAAS;

use GuzzleHttp\Promise\PromiseInterface;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Http;
use WeDevBr\Celcoin\Clients\CelcoinBAAS;
use WeDevBr\Celcoin\Enums\AccountOnboardingTypeEnum;
use WeDevBr\Celcoin\Tests\GlobalStubs;
use WeDevBr\Celcoin\Tests\TestCase;
use WeDevBr\Celcoin\Types\BAAS\AccountBusiness;

class CreateAccountBusinessTest extends TestCase
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
                    CelcoinBAAS::CREATE_ACCOUNT_BUSINESS,
                ) => self::stubSuccess(),
            ],
        );

        $baas = new CelcoinBAAS();

        $firstBusinessName = $fake->firstName();
        $lastBusinessName = $fake->lastName();

        $firstName = $fake->firstName();
        $lastName = $fake->lastName();

        $response = $baas->createAccountBusiness(
            new AccountBusiness(
                [
                    "clientCode" => $fake->uuid(),
                    "accountOnboardingType" => AccountOnboardingTypeEnum::BANK_ACCOUNT,
                    "documentNumber" => $fake->cnpj(false),
                    "contactNumber" => sprintf('+5511%s', $fake->cellphone(false)),
                    "businessEmail" => $fake->email(),
                    "businessName" => sprintf('%s %s LTDA', $firstBusinessName, $lastBusinessName),
                    "tradingName" => $firstBusinessName,
                    "owner" => [
                        [
                            "documentNumber" => $fake->cpf(false),
                            "phoneNumber" => sprintf('+5511%s', $fake->cellphone(false)),
                            "email" => $fake->email(),
                            "motherName" => sprintf('%s %s', $fake->firstNameFemale(), $fake->lastName()),
                            "fullName" => sprintf('%s %s', $firstName, $lastName),
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
                                "latitude" => $fake->latitude(-46, -47),
                            ],
                            "isPoliticallyExposedPerson" => false,
                        ],
                    ],
                    "businessAddress" => [
                        "postalCode" => '01153000',
                        "street" => $fake->streetName(),
                        "number" => $fake->buildingNumber(),
                        "addressComplement" => "Em frente ao parque.",
                        "neighborhood" => 'Centro',
                        "city" => $fake->city(),
                        "state" => $fake->stateAbbr(),
                        "longitude" => $fake->longitude(-23, -24),
                        "latitude" => $fake->latitude(-46, -47),
                    ],
                    "cadastraChavePix" => false,
                ],
            ),
        );

        $this->assertEquals('PROCESSING', $response['status']);
    }

    static private function stubSuccess(): PromiseInterface
    {
        return Http::response(
            [
                "version" => "1.0.0",
                "status" => "PROCESSING",
                "body" => [
                    "onBoardingId" => "39c8e322-9192-498d-947e-2daa4dfc749e",
                ],
            ],
            Response::HTTP_OK,
        );
    }
}
