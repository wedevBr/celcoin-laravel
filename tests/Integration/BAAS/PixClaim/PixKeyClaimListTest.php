<?php

namespace WeDevBr\Celcoin\Tests\Integration\BAAS\PixClaim;

use GuzzleHttp\Promise\PromiseInterface;
use Illuminate\Http\Client\RequestException;
use Illuminate\Support\Facades\Http;
use Symfony\Component\HttpFoundation\Response;
use WeDevBr\Celcoin\Clients\CelcoinBAASPIX;
use WeDevBr\Celcoin\Enums\ClaimStatusEnum;
use WeDevBr\Celcoin\Enums\ClaimTypeEnum;
use WeDevBr\Celcoin\Tests\GlobalStubs;
use WeDevBr\Celcoin\Tests\TestCase;

use function PHPUnit\Framework\assertEquals;

class PixKeyClaimListTest extends TestCase
{
    /**
     * @throws RequestException
     */
    public function testClaimPixKey()
    {
        Http::fake(
            [
                config('celcoin.login_url') => GlobalStubs::loginResponse(),
                CelcoinBAASPIX::CLAIM_LIST => self::stubSuccess(),
            ],
        );

        $pixDict = new CelcoinBAASPIX();
        $result = $pixDict->claimList();

        assertEquals('SUCCESS', $result['status']);
    }

    /**
     * @throws RequestException
     */
    public function testClaimPixKeyWithParams()
    {
        Http::fake(
            [
                config('celcoin.login_url') => GlobalStubs::loginResponse(),
                CelcoinBAASPIX::CLAIM_LIST.'*' => self::stubSuccess(),
            ],
        );

        $pixDict = new CelcoinBAASPIX();
        $result = $pixDict->claimList([
            'Status' => ClaimStatusEnum::CANCELLED,
            'claimType' => ClaimTypeEnum::OWNERSHIP,
        ]);
        assertEquals('SUCCESS', $result['status']);
    }

    private static function stubSuccess(): PromiseInterface
    {
        return Http::response(
            [
                'version' => '1.0.0',
                'status' => 'SUCCESS',
                'body' => [
                    'claims' => [
                        [
                            'id' => '8bbc0ba5-2aee-44a0-a3c9-b897802a9f66',
                            'claimType' => 'OWNERSHIP',
                            'key' => 'fulanodetal@gmail.com',
                            'keyType' => 'EMAIL',
                            'claimerAccount' => [
                                'participant' => '30306294',
                                'branch' => '0001',
                                'account' => '30053913742139',
                                'accountType' => 'TRAN',
                            ],
                            'claimer' => [
                                'personType' => 'NATURAL_PERSON',
                                'taxId' => '34335125070',
                                'name' => 'João da Silva Junior',
                            ],
                            'donorParticipant' => '30306294',
                            'status' => 'OPEN',
                            'createTimestamp' => '2023-05-01T13:05:09',
                            'completionPeriodEnd' => '2023-05-01T13:05:09',
                            'resolutionPeriodEnd' => '2023-05-01T13:05:09',
                            'lastModified' => '2023-05-01T13:05:09',
                            'donorAccount' => [
                                'account' => '30053913742139',
                                'branch' => '0001',
                                'taxId' => '34335125070',
                                'name' => 'João da Silva Junior',
                            ],
                        ],
                    ],
                ],
            ],
            Response::HTTP_OK,
        );
    }

    public function testClaimBadRequest()
    {
        Http::fake(
            [
                config('celcoin.login_url') => GlobalStubs::loginResponse(),
                CelcoinBAASPIX::CLAIM_LIST => self::stubBadRequest(),
            ],
        );

        $this->expectException(RequestException::class);

        $pixDict = new CelcoinBAASPIX();
        $result = $pixDict->claimList();
        assertEquals('ERROR', $result['status']);
        assertEquals('CIE999', $result['error']['errorCode']);
    }

    private static function stubBadRequest(): PromiseInterface
    {
        return Http::response([
            'version' => '1.0.0',
            'status' => 'ERROR',
            'error' => [
                'errorCode' => 'CIE999',
                'message' => 'Ocorreu um erro interno durante a chamada da api.',
            ],
        ], Response::HTTP_BAD_REQUEST);
    }
}
