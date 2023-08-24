<?php

namespace WeDevBr\Celcoin\Tests\Integration\BAAS;

use GuzzleHttp\Promise\PromiseInterface;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Http;
use WeDevBr\Celcoin\Clients\CelcoinBAAS;
use WeDevBr\Celcoin\Tests\GlobalStubs;
use WeDevBr\Celcoin\Tests\TestCase;

class GetInfoAccountNaturalPersonTest extends TestCase
{

    /**
     * @return void
     */
    public function testSuccess()
    {
        Http::fake(
            [
                config('celcoin.login_url') => GlobalStubs::loginResponse(),
                sprintf(
                    '%s%s*',
                    config('api_url'),
                    CelcoinBAAS::GET_INFO_ACCOUNT_NATURAL_PERSON,
                ) => self::stubSuccess(),
            ],
        );

        $baas = new CelcoinBAAS();

        $response = $baas->getInfoAccountNaturalPerson('123456');

        $this->assertEquals('SUCCESS', $response['status']);
    }

    static private function stubSuccess(): PromiseInterface
    {
        return Http::response(
            [
                "version" => "1.0.0",
                "status" => "SUCCESS",
                "body" => [
                    "statusAccount" => "ATIVO",
                    "documentNumber" => "25400754015",
                    "phoneNumber" => "+5512981175704",
                    "email" => "email4@email.com",
                    "motherName" => "Nome Sobrenome",
                    "fullName" => "Nome Sobrenome",
                    "socialName" => "Nome",
                    "birthDate" => "31-12-1984",
                    "address" => [
                        "postalCode" => "12211400",
                        "street" => "Av Paulista",
                        "number" => "313",
                        "addressComplement" => "Em frente ao parque.",
                        "neighborhood" => "Bairro",
                        "city" => "São Paulo",
                        "state" => "SP",
                        "longitude" => "-46.6488",
                        "latitude" => "-23.6288",
                    ],
                    "isPoliticallyExposedPerson" => false,
                    "account" => [
                        "branch" => "0001",
                        "account" => "300539137798",
                    ],
                    "createDate" => "2022-10-28T13:50:55",
                ],
            ],
            Response::HTTP_OK,
        );
    }
}
