<?php

namespace WeDevBr\Celcoin\Tests\Integration\BAAS;

use GuzzleHttp\Promise\PromiseInterface;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Http;
use WeDevBr\Celcoin\Clients\CelcoinBAAS;
use WeDevBr\Celcoin\Tests\GlobalStubs;
use WeDevBr\Celcoin\Tests\TestCase;
use WeDevBr\Celcoin\Types\BAAS\AccountManagerBusiness;

class UpdateAccountBusinessTest extends TestCase
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
                    '%s%s*',
                    config('api_url'),
                    sprintf(CelcoinBAAS::UPDATE_ACCOUNT_BUSINESS, '12345', '12345'),
                ) => self::stubSuccess(),
            ],
        );

        $baas = new CelcoinBAAS();

        $firstName = $fake->firstName();
        $lastName = $fake->lastName();

        $response = $baas->updateAccountBusiness(
            '12345',
            '12345',
            new AccountManagerBusiness(
                [
                    'contactNumber' => sprintf('+5511%s', $fake->cellphone(false)),
                    'businessEmail' => $fake->email(),
                    'owners' => [
                        [
                            'documentNumber' => $fake->cpf(false),
                            'phoneNumber' => sprintf('+5511%s', $fake->cellphone(false)),
                            'email' => $fake->email(),
                            'fullName' => sprintf('%s %s', $firstName, $lastName),
                            'socialName' => $firstName,
                            'birthDate' => '15-01-1981',
                            'motherName' => sprintf('%s %s', $fake->firstNameFemale(), $fake->lastName()),
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
                    ],
                    'businessAddress' => [
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
                    'cadastraChavePix' => false,
                ],
            ),
        );

        $this->assertEquals('SUCCESS', $response['status']);
    }

    private static function stubSuccess(): PromiseInterface
    {
        return Http::response(
            [
                'version' => '1.0.0',
                'status' => 'SUCCESS',
            ],
            Response::HTTP_OK,
        );
    }
}
