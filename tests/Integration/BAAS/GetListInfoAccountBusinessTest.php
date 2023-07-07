<?php

namespace Tests\Integration\BAAS;

use Carbon\Carbon;
use GuzzleHttp\Promise\PromiseInterface;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Http;
use Tests\GlobalStubs;
use Tests\TestCase;
use WeDevBr\Celcoin\Clients\CelcoinBAAS;

class GetListInfoAccountBusinessTest extends TestCase
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
                    CelcoinBAAS::GET_LIST_INFO_ACCOUNT_BUSINESS
                ) => self::stubSuccess()
            ]
        );

        $baas = new CelcoinBAAS();

        $response = $baas->getListInfoAccountBusiness(Carbon::createFromFormat('Y-m-d', '2022-06-28'), Carbon::createFromFormat('Y-m-d', '2022-06-30'));

        $this->assertEquals('SUCCESS', $response['status']);
    }

    static private function stubSuccess(): PromiseInterface
    {
        return Http::response(
            [
                "version" => "1.0.0",
                "status" => "SUCCESS",
                "totalItems" => 3,
                "currentPage" => 1,
                "totalPages" => 1,
                "dateFrom" => "22/10/2022 00:00:00",
                "dateTo" => "28/10/2022 23:59:59",
                "subAccounts" => [
                    [
                        "statusAccount" => "ATIVO",
                        "documentNumber" => "25400754015",
                        "phoneNumber" => "+5512981175704",
                        "email" => "email4@email.com",
                        "motherName" => "Nome Sobrenome",
                        "fullName" => "Nome Sobrenome",
                        "socialName" => "Nome",
                        "birthDate" => "31-12-1984",
                        "address" => [
                            "postalCode" => "06455030",
                            "street" => "Rua das Andorinhas",
                            "number" => "343",
                            "addressComplement" => "proximo a lanchonete do zeca",
                            "neighborhood" => "Rua das Maravilhas",
                            "city" => "Sao Paulo",
                            "state" => "SP",
                            "longitude" => null,
                            "latitude" => null
                        ],
                        "isPoliticallyExposedPerson" => false,
                        "createDate" => "2022-10-25T20:33:34",
                        "closeDate" => "2022-10-25T20:33:47",
                        "closeReason" => "Motivo X"
                    ],
                    [
                        "statusAccount" => "ATIVO",
                        "documentNumber" => "25400754015",
                        "phoneNumber" => "+5512981175704",
                        "email" => "email4@email.com",
                        "motherName" => "Nome Sobrenome",
                        "fullName" => "Nome Sobrenome",
                        "socialName" => "Nome",
                        "birthDate" => "31-12-1984",
                        "address" => [
                            "postalCode" => "06455030",
                            "street" => "Rua das Andorinhas",
                            "number" => "343",
                            "addressComplement" => "proximo a lanchonete do zeca",
                            "neighborhood" => "Rua das Maravilhas",
                            "city" => "Sao Paulo",
                            "state" => "SP",
                            "longitude" => null,
                            "latitude" => null
                        ],
                        "isPoliticallyExposedPerson" => false,
                        "createDate" => "2022-10-25T20:33:54",
                        "closeDate" => "2022-10-25T20:34:06",
                        "closeReason" => "Desejo encerrar a conta..."
                    ]
                ]
            ],
            Response::HTTP_OK
        );
    }
}
