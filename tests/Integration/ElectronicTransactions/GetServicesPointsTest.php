<?php

namespace Tests\Integration\ElectronicTransactions;

use GuzzleHttp\Promise\PromiseInterface;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Http;
use Tests\GlobalStubs;
use Tests\TestCase;
use WeDevBr\Celcoin\Clients\CelcoinElectronicTransactions;
use WeDevBr\Celcoin\Types\ElectronicTransactions\ServicesPoints;

class GetServicesPointsTest extends TestCase
{

    /**
     * @return void
     */
    public function testSuccessAccountCheck()
    {
        Http::fake(
            [
                config('celcoin.login_url') => GlobalStubs::loginResponse(),
                sprintf(
                    '%s%s',
                    config('api_url'),
                    CelcoinElectronicTransactions::GET_SERVICES_POINTS_ENDPOINT
                ) => self::stubSuccess()
            ]
        );

        $baas = new CelcoinElectronicTransactions();
        $response = $baas->getServicesPoints(new ServicesPoints([
            'latitude' => -22.89369,
            'longitude' => -47.025433,
            'namePartner' => 'TECBAN_BANCO24H',
            'radius' => 99000,
            'page' => 1,
            'size' => 50,
        ]));

        $this->assertEquals(0, $response['status']);
    }

    static private function stubSuccess(): PromiseInterface
    {
        return Http::response(
            [
                "stores" => [
                    [
                        "description" => null,
                        "Address" => [
                            "district" => "VL BRANDINA",
                            "city" => "CAMPINAS",
                            "state" => "SP",
                            "number" => "777",
                            "Rua" => "AV IGUATEMI"
                        ],
                        "location" => [
                            "latitude" => -22.89369,
                            "longitude" => -47.025433
                        ],
                        "storeId" => "30187",
                        "name" => "SHOP IGUATEMI CPQ I",
                        "allowedTransactions" => null
                    ],
                    [
                        "description" => null,
                        "Address" => [
                            "district" => "VL BRANDINA",
                            "city" => "CAMPINAS",
                            "state" => "SP",
                            "number" => "777",
                            "Rua" => "AV IGUATEMI"
                        ],
                        "location" => [
                            "latitude" => -22.89369,
                            "longitude" => -47.025433
                        ],
                        "storeId" => "30204",
                        "name" => "SHOP IGUATEMI CPQ II",
                        "allowedTransactions" => null
                    ],
                    [
                        "description" => null,
                        "Address" => [
                            "district" => "VL BRANDINA",
                            "city" => "CAMPINAS",
                            "state" => "SP",
                            "number" => "777",
                            "Rua" => "AV IGUATEMI"
                        ],
                        "location" => [
                            "latitude" => -22.89369,
                            "longitude" => -47.025433
                        ],
                        "storeId" => "37153",
                        "name" => "SHOP IGUATEMI CPQ IV",
                        "allowedTransactions" => null
                    ],
                    [
                        "description" => null,
                        "Address" => [
                            "district" => "TAQUARA",
                            "city" => "RIO DE JANEIRO",
                            "state" => "RJ",
                            "number" => "452",
                            "Rua" => "ESTRADA DA SOCA"
                        ],
                        "location" => [
                            "latitude" => -22.892096,
                            "longitude" => -47.02865
                        ],
                        "storeId" => "21438",
                        "name" => "PAD ZE DO PUDIM",
                        "allowedTransactions" => null
                    ],
                    [
                        "description" => null,
                        "Address" => [
                            "district" => "JD FLAMBOYANT",
                            "city" => "CAMPINAS",
                            "state" => "SP",
                            "number" => "1237",
                            "Rua" => "AV JOSE BONIFACIO"
                        ],
                        "location" => [
                            "latitude" => -22.88778,
                            "longitude" => -47.03143
                        ],
                        "storeId" => "24143",
                        "name" => "POSTO AVENIDA",
                        "allowedTransactions" => null
                    ],
                    [
                        "description" => null,
                        "Address" => [
                            "district" => "JD FLAMBOYANT",
                            "city" => "CAMPINAS",
                            "state" => "SP",
                            "number" => "22",
                            "Rua" => "RUA CAJAMAR"
                        ],
                        "location" => [
                            "latitude" => -22.883777,
                            "longitude" => -47.036805
                        ],
                        "storeId" => "16388",
                        "name" => "AP FLAMBOYANT ",
                        "allowedTransactions" => null
                    ],
                    [
                        "description" => null,
                        "Address" => [
                            "district" => "CAMBUI",
                            "city" => "CAMPINAS",
                            "state" => "SP",
                            "number" => "2101",
                            "Rua" => "AV JOSE DE SOUZA CAMPOS"
                        ],
                        "location" => [
                            "latitude" => -22.886957,
                            "longitude" => -47.044606
                        ],
                        "storeId" => "23810",
                        "name" => "POSTO ANDORINHAS CAMBUI ",
                        "allowedTransactions" => null
                    ],
                    [
                        "description" => null,
                        "Address" => [
                            "district" => "JD BELA VISTA",
                            "city" => "CAMPINAS",
                            "state" => "SP",
                            "number" => "1270",
                            "Rua" => "AV NOSSA SENHORA DE FATIMA"
                        ],
                        "location" => [
                            "latitude" => -22.878524,
                            "longitude" => -47.044303
                        ],
                        "storeId" => "26802",
                        "name" => "SUP DALBEN II",
                        "allowedTransactions" => null
                    ],
                    [
                        "description" => null,
                        "Address" => [
                            "district" => "JD BELA VISTA",
                            "city" => "CAMPINAS",
                            "state" => "SP",
                            "number" => "1270",
                            "Rua" => "AV NOSSA SENHORA DE FATIMA"
                        ],
                        "location" => [
                            "latitude" => -22.878524,
                            "longitude" => -47.044303
                        ],
                        "storeId" => "31357",
                        "name" => "SUP DALBEN II",
                        "allowedTransactions" => null
                    ],
                    [
                        "description" => null,
                        "Address" => [
                            "district" => "JD BELA VISTA",
                            "city" => "CAMPINAS",
                            "state" => "SP",
                            "number" => "1270",
                            "Rua" => "AV NOSSA SENHORA DE FATIMA"
                        ],
                        "location" => [
                            "latitude" => -22.878524,
                            "longitude" => -47.044303
                        ],
                        "storeId" => "8045",
                        "name" => "SUP DALBEN I ",
                        "allowedTransactions" => null
                    ],
                    [
                        "description" => null,
                        "Address" => [
                            "district" => "CAMBUI",
                            "city" => "CAMPINAS",
                            "state" => "SP",
                            "number" => "616",
                            "Rua" => "RUA ALECRINS"
                        ],
                        "location" => [
                            "latitude" => -22.889135,
                            "longitude" => -47.049409
                        ],
                        "storeId" => "51584",
                        "name" => "P. ACUCAR ALECRINS",
                        "allowedTransactions" => null
                    ],
                    [
                        "description" => null,
                        "Address" => [
                            "district" => "JD BELA VISTA",
                            "city" => "CAMPINAS",
                            "state" => "SP",
                            "number" => "326",
                            "Rua" => "AV JULIO PRESTES"
                        ],
                        "location" => [
                            "latitude" => -22.877243,
                            "longitude" => -47.044702
                        ],
                        "storeId" => "27286",
                        "name" => "AP ALFEMAR TAQUARAL",
                        "allowedTransactions" => null
                    ],
                    [
                        "description" => null,
                        "Address" => [
                            "district" => "JD PARAISO",
                            "city" => "CAMPINAS",
                            "state" => "SP",
                            "number" => "1802",
                            "Rua" => "AV PRINCESA D' OESTE"
                        ],
                        "location" => [
                            "latitude" => -22.90727,
                            "longitude" => -47.045195
                        ],
                        "storeId" => "38287",
                        "name" => "DIA PRINCESA D OESTE LJ 475 ",
                        "allowedTransactions" => null
                    ]
                ],
                "errorCode" => "000",
                "message" => "SUCESSO",
                "status" => 0
            ],
            Response::HTTP_OK
        );
    }
}
