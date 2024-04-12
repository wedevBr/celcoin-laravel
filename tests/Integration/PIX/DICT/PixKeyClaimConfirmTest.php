<?php

namespace WeDevBr\Celcoin\Tests\Integration\PIX\DICT;

use GuzzleHttp\Promise\PromiseInterface;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Http\Client\RequestException;
use Illuminate\Support\Facades\Http;
use Symfony\Component\HttpFoundation\Response;
use WeDevBr\Celcoin\Clients\CelcoinPIXDICT;
use WeDevBr\Celcoin\Tests\GlobalStubs;
use WeDevBr\Celcoin\Tests\TestCase;
use WeDevBr\Celcoin\Types\PIX\ClaimAnswer;

use function PHPUnit\Framework\assertEquals;

class PixKeyClaimConfirmTest extends TestCase
{
    use WithFaker;

    /**
     * @throws RequestException
     */
    public function testClaimPixKey()
    {
        Http::fake(
            [
                config('celcoin.login_url') => GlobalStubs::loginResponse(),
                CelcoinPIXDICT::CLAIM_CONFIRM => self::stubSuccess(),
            ],
        );

        $pixDict = new CelcoinPIXDICT();
        $result = $pixDict->claimConfirm($this->fakeClaimConfirmBody());

        assertEquals('CONFIRMED', $result['status']);
    }

    private static function stubSuccess(): PromiseInterface
    {
        return Http::response(
            [
                'version' => '1.0.0',
                'status' => 'CONFIRMED',
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
                    'resolutionPeriodEnd' => '2023-08-10T17',
                    'lastModified' => '2023-08-11T17:11:33',
                ],
            ],
            Response::HTTP_OK,
        );
    }

    private function fakeClaimConfirmBody(): ClaimAnswer
    {
        return new ClaimAnswer([
            'id' => $this->faker()->uuid,
            'reason' => 'USER_REQUESTED',
        ]);
    }

    public function testClaimBadRequest()
    {
        Http::fake(
            [
                config('celcoin.login_url') => GlobalStubs::loginResponse(),
                CelcoinPIXDICT::CLAIM_CONFIRM => self::stubBadRequest(),
            ],
        );

        $this->expectException(RequestException::class);

        $pixDict = new CelcoinPIXDICT();
        $result = $pixDict->claimConfirm($this->fakeClaimConfirmBody());
        assertEquals('ERROR', $result['status']);
        assertEquals('CBE307', $result['error']['errorCode']);
    }

    private static function stubBadRequest(): PromiseInterface
    {
        return Http::response([
            'version' => '1.0.0',
            'status' => 'ERROR',
            'error' => [
                'errorCode' => 'CBE307',
                'message' => 'Não foi possível cancelar essa Claim, pois a mesma não está mais pendente.',
            ],
        ], Response::HTTP_BAD_REQUEST);
    }
}
