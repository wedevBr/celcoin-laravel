<?php

namespace WeDevBr\Celcoin\Tests\Integration\Assistant;

use GuzzleHttp\Promise\PromiseInterface;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Http;
use WeDevBr\Celcoin\Clients\CelcoinAssistant;
use WeDevBr\Celcoin\Tests\GlobalStubs;
use WeDevBr\Celcoin\Tests\TestCase;

class FindInstitutionsTest extends TestCase
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
                    '%s%s',
                    config('api_url'),
                    CelcoinAssistant::FIND_INSTITUTIONS_ENDPOINT,
                ) => self::stubSuccess(),
            ],
        );

        $assistant = new CelcoinAssistant();
        $response = $assistant->findInstitutions();
        $this->assertEquals(0, $response['status']);
    }

    private static function stubSuccess(): PromiseInterface
    {
        return Http::response(
            [
                'convenants' => [
                    [
                        'timeLimit' => '12:00',
                        'mask' => '99______________9999____________________________',
                        'nomeconvenant' => 'EXEMPLO 1',
                        'type' => 'ESTADUAL',
                        'UF' => [
                            'SP',
                            'RJ',
                        ],
                    ],
                ],
                'errorCode' => '000',
                'message' => 'SUCESSO',
                'status' => 0,
            ],
            Response::HTTP_OK,
        );
    }
}
