<?php

namespace Tests\Integration\PIX\COB;

use GuzzleHttp\Promise\PromiseInterface;
use Illuminate\Http\Client\RequestException;
use Illuminate\Support\Facades\Http;
use Symfony\Component\HttpFoundation\Response;
use Tests\GlobalStubs;
use Tests\TestCase;
use WeDevBr\Celcoin\Clients\CelcoinPIXCOB;

class COBPayloadTest extends TestCase
{
    /**
     * @throws RequestException
     */
    final public function testPayloadCobSuccess(): void
    {
        $transactionId = 123456;
        $fetchUrl = sprintf(CelcoinPIXCOB::FETCH_COB_PIX_URL, $transactionId);
        Http::fake(
            [
                config('celcoin.login_url') => GlobalStubs::loginResponse(),
                sprintf(CelcoinPIXCOB::PAYLOAD_COB_PIX_URL, urlencode($fetchUrl)) => self::stubSuccess(),
            ]
        );

        $pixCOB = new CelcoinPIXCOB();
        $result = $pixCOB->payloadCOBPIX($fetchUrl);
        $this->assertEquals('ATIVA', $result['status']);
        $this->assertEquals(15.01, $result['valor']['original']);
    }

    private static function stubSuccess(): PromiseInterface
    {
        //TODO (aronpc) : Verificar resposta em ingles/portugues?
        return Http::response([
            'status' => 'ATIVA',
            'infoAdicionais' => NULL,
            'txid' => 'kk6g232xel65a0daee4dd13kk9192148',
            'chave' => 'testepix@celcoin.com.br',
            'solicitacaoPagador' => NULL,
            'valor' => [
                'original' => '15.01',
                'abatimento' => NULL,
                'desconto' => NULL,
                'multa' => NULL,
                'juros' => NULL,
                'final' => NULL,
                'modalidadeAlteracao' => 0,
                'retirada' => NULL,
            ],
            'calendario' => [
                'criacao' => '2022-03-22T14:20:47Z',
                'expiracao' => 86400,
                'apresentacao' => '2022-03-22T14:22:24Z',
                'validadeAposVencimento' => 0,
            ],
            'revisao' => 0,
        ], Response::HTTP_OK);
    }


    /**
     * @throws RequestException
     */
    final public function testPayloadCobNotFound(): void
    {

        $transactionId = 123456;
        $fetchUrl = sprintf(CelcoinPIXCOB::FETCH_COB_PIX_URL, $transactionId);
        Http::fake(
            [
                config('celcoin.login_url') => GlobalStubs::loginResponse(),
                sprintf(CelcoinPIXCOB::PAYLOAD_COB_PIX_URL, urlencode($fetchUrl)) => self::stubNotFound()
            ]
        );

        $this->expectException(RequestException::class);
        try {
            $pixCOB = new CelcoinPIXCOB();
            $pixCOB->payloadCOBPIX($fetchUrl);
        } catch (RequestException $exception) {
            $result = $exception->response->json();
            $this->assertEquals('VL002', $result['errorCode']);
            throw $exception;
        }
    }

    /**
     * @return PromiseInterface
     */
    private static function stubNotFound(): PromiseInterface
    {
        return Http::response([
            'message' => 'Não foi possível localizar a cobrança associada ao parâmetro informado.',
            'errorCode' => 'VL002',
        ],
            Response::HTTP_BAD_REQUEST
        );
    }
}
