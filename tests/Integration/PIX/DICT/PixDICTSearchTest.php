<?php

namespace WeDevBr\Celcoin\Tests\Integration\PIX\DICT;

use GuzzleHttp\Promise\PromiseInterface;
use Illuminate\Http\Client\RequestException;
use Illuminate\Support\Facades\Http;
use Illuminate\Validation\ValidationException;
use Symfony\Component\HttpFoundation\Response;
use WeDevBr\Celcoin\Clients\CelcoinPIXDICT;
use WeDevBr\Celcoin\Tests\GlobalStubs;
use WeDevBr\Celcoin\Tests\TestCase;
use WeDevBr\Celcoin\Types\PIX\DICT;

use function PHPUnit\Framework\assertEquals;

class PixDICTSearchTest extends TestCase
{
    public function testSearchDICT()
    {
        Http::fake(
            [
                config('celcoin.login_url') => GlobalStubs::loginResponse(),
                CelcoinPIXDICT::POST_SEARCH_DICT => self::stubSuccess(),
            ],
        );

        $pixDict = new CelcoinPIXDICT();
        $result = $pixDict->searchDICT($this->fakeDictBody());

        assertEquals('EMAIL', $result['keyType']);
    }

    private static function stubSuccess(): PromiseInterface
    {
        return Http::response([
            'key' => 'testepix@celcoin.com.br',
            'keyType' => 'EMAIL',
            'account' => [
                'openingDate' => '2020-08-13T13:49:03Z',
                'participant' => '30306294',
                'branch' => 20,
                'accountNumber' => '42161',
                'accountType' => 'CACC',
            ],
            'owner' => [
                'taxIdNumber' => '12312312300',
                'type' => 'NATURAL_PERSON',
                'name' => 'Teste Celcoin',
                'tradeName' => '',
            ],
            'endtoendid' => 'E1393589320220720205100627741380',
            'creationDate' => '2021-02-24T20:58:27.376Z',
            'keyOwnershipDate' => '2021-02-24T20:58:27.375Z',
            'responseTime' => '2022-07-20T20:51:59.427Z',
            'openClaimCreationDate' => null,
            'statistics' => [
                'lastUpdated' => '2022-07-20T09:01:10.426Z',
                'counters' => [
                    [
                        'type' => 'SETTLEMENTS',
                        'by' => 'KEY',
                        'd3' => '0',
                        'd30' => '0',
                        'm6' => '0',
                    ],
                    [
                        'type' => 'SETTLEMENTS',
                        'by' => 'OWNER',
                        'd3' => '0',
                        'd30' => '2',
                        'm6' => '78',
                    ],
                    [
                        'type' => 'SETTLEMENTS',
                        'by' => 'ACCOUNT',
                        'd3' => '0',
                        'd30' => '2',
                        'm6' => '78',
                    ],
                    [
                        'type' => 'REPORTED_FRAUDS',
                        'by' => 'KEY',
                        'd3' => '0',
                        'd30' => '0',
                        'm6' => '0',
                    ],
                    [
                        'type' => 'REPORTED_FRAUDS',
                        'by' => 'OWNER',
                        'd3' => '0',
                        'd30' => '0',
                        'm6' => '0',
                    ],
                    [
                        'type' => 'REPORTED_FRAUDS',
                        'by' => 'ACCOUNT',
                        'd3' => '0',
                        'd30' => '0',
                        'm6' => '0',
                    ],
                    [
                        'type' => 'CONFIRMED_FRAUDS',
                        'by' => 'KEY',
                        'd3' => '0',
                        'd30' => '0',
                        'm6' => '0',
                    ],
                    [
                        'type' => 'CONFIRMED_FRAUDS',
                        'by' => 'OWNER',
                        'd3' => '0',
                        'd30' => '0',
                        'm6' => '0',
                    ],
                    [
                        'type' => 'CONFIRMED_FRAUDS',
                        'by' => 'ACCOUNT',
                        'd3' => '0',
                        'd30' => '0',
                        'm6' => '0',
                    ],
                    [
                        'type' => 'REJECTED',
                        'by' => 'KEY',
                        'd3' => '0',
                        'd30' => '0',
                        'm6' => '0',
                    ],
                    [
                        'type' => 'REJECTED',
                        'by' => 'OWNER',
                        'd3' => '0',
                        'd30' => '0',
                        'm6' => '0',
                    ],
                    [
                        'type' => 'REJECTED',
                        'by' => 'ACCOUNT',
                        'd3' => '0',
                        'd30' => '0',
                        'm6' => '0',
                    ],
                ],
            ],
            Response::HTTP_OK,
        ]);
    }

    private function fakeDictBody(): DICT
    {
        return new DICT([
            'payerId' => '12123123000100',
            'key' => '+5511988889999',
        ]);
    }

    public function testSearchDictNotFoundData()
    {
        Http::fake(
            [
                config('celcoin.login_url') => GlobalStubs::loginResponse(),
                CelcoinPIXDICT::POST_SEARCH_DICT => self::stubNotFoundData(),
            ],
        );

        $this->expectException(RequestException::class);

        $pixDict = new CelcoinPIXDICT();
        $pixDict->searchDICT($this->fakeDictBody());
    }

    private static function stubNotFoundData(): PromiseInterface
    {
        return Http::response([
            'code' => '909',
            'description' => 'Não foram encontrados dados para a chave informada',
        ], Response::HTTP_BAD_REQUEST);
    }

    public function testSearchDictTechnicalProblem()
    {
        Http::fake(
            [
                config('celcoin.login_url') => GlobalStubs::loginResponse(),
                CelcoinPIXDICT::POST_SEARCH_DICT => self::stubTechnicalProblem(),
            ],
        );

        $this->expectException(RequestException::class);

        $pixDict = new CelcoinPIXDICT();
        $pixDict->searchDICT($this->fakeDictBody());
    }

    private static function stubTechnicalProblem(): PromiseInterface
    {
        return Http::response([
            'code' => '513',
            'description' => 'Ocorreu um problema ao tentar comunicar o parceiro.',
        ], Response::HTTP_BAD_REQUEST);
    }

    public function testSearchDictInternalServerError()
    {
        Http::fake(
            [
                config('celcoin.login_url') => GlobalStubs::loginResponse(),
                CelcoinPIXDICT::POST_SEARCH_DICT => Http::response([], Response::HTTP_INTERNAL_SERVER_ERROR),
            ],
        );

        $this->expectException(RequestException::class);

        $pixDict = new CelcoinPIXDICT();
        $pixDict->searchDICT($this->fakeDictBody());
    }

    /**
     * @throws RequestException
     */
    public function testVerifyDictValidationError()
    {
        Http::fake(
            [
                config('celcoin.login_url') => GlobalStubs::loginResponse(),
                CelcoinPIXDICT::POST_SEARCH_DICT => self::stubSuccess(),
            ],
        );

        $this->expectException(ValidationException::class);

        $pixDict = new CelcoinPIXDICT();
        $pixDict->verifyDICT(new DICT([]));
    }
}
