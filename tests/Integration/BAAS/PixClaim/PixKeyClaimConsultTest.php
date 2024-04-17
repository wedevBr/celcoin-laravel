<?php

namespace WeDevBr\Celcoin\Tests\Integration\BAAS\PixClaim;

use GuzzleHttp\Promise\PromiseInterface;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Http\Client\RequestException;
use Illuminate\Support\Facades\Http;
use Symfony\Component\HttpFoundation\Response;
use WeDevBr\Celcoin\Clients\CelcoinBAASPIX;
use WeDevBr\Celcoin\Tests\GlobalStubs;
use WeDevBr\Celcoin\Tests\TestCase;
use function PHPUnit\Framework\assertEquals;

class PixKeyClaimConsultTest extends TestCase
{
    use WithFaker;

    private string $uuid;

    public function setUp(): void
    {
        parent::setUp();
        $this->uuid = '8bbc0ba5-2aee-44a0-a3c9-b897802a9f66';
    }

    /**
     * @throws RequestException
     */
    public function testClaimConsult()
    {
        Http::fake(
            [
                config('celcoin.login_url') => GlobalStubs::loginResponse(),
                CelcoinBAASPIX::CLAIM_DICT.'/*' => self::stubSuccess(),
            ],
        );

        $pixDict = new CelcoinBAASPIX();
        $result = $pixDict->claimConsult($this->uuid);

        assertEquals('SUCCESS', $result['status']);
        assertEquals($this->uuid, $result['body']['id']);
    }

    private static function stubSuccess(): PromiseInterface
    {
        return Http::response(
            [
                'version' => '1.0.0',
                'status' => 'SUCCESS',
                'body' => [
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
                    'createTimestamp' => '2023-05-01T13:05:09',
                    'completionPeriodEnd' => '2023-05-01T13:05:09',
                    'resolutionPeriodEnd' => '2023-05-01T13:05:09',
                    'lastModified' => '2023-05-01T13:05:09',
                    'confirmReason' => 'USER_REQUESTED',
                    'cancelReason' => 'FRAUD',
                    'cancelledBy' => 'DONOR',
                    'donorAccount' => [
                        'account' => '30053913742139',
                        'branch' => '0001',
                        'taxId' => '34335125070',
                        'name' => 'João da Silva',
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
                CelcoinBAASPIX::CLAIM_DICT.'/*' => self::stubBadRequest(),
            ],
        );

        $this->expectException(RequestException::class);

        $pixDict = new CelcoinBAASPIX();
        $result = $pixDict->claimConsult($this->uuid);
        assertEquals('ERROR', $result['status']);
        assertEquals('CBE320', $result['error']['errorCode']);
    }

    private static function stubBadRequest(): PromiseInterface
    {
        return Http::response([
            'version' => '1.0.0',
            'status' => 'ERROR',
            'error' => [
                'errorCode' => 'CBE320',
                'message' => 'Claim não encontrada.',
            ],
        ], Response::HTTP_BAD_REQUEST);
    }
}
