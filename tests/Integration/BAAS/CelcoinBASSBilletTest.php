<?php

namespace WeDevBr\Celcoin\Tests\Integration\BAAS;

use Exception;
use GuzzleHttp\Promise\PromiseInterface;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Http\Client\RequestException;
use Illuminate\Support\Facades\Http;
use WeDevBr\Celcoin\Clients\CelcoinBAASBillet;
use WeDevBr\Celcoin\Tests\GlobalStubs;
use WeDevBr\Celcoin\Tests\TestCase;
use WeDevBr\Celcoin\Types\BAAS\Billet;
use WeDevBr\Celcoin\Types\BAAS\BilletDebtor;
use WeDevBr\Celcoin\Types\BAAS\BilletReceiver;

class CelcoinBASSBilletTest extends TestCase
{
    use WithFaker;

    /**
     * @throws RequestException
     */
    public function testCreateBillet()
    {
        $fake = fake('pt_BR');
        Http::fake(
            [
                config('celcoin.login_url') => GlobalStubs::loginResponse(),
                sprintf(
                    '%s%s',
                    config('api_url'),
                    CelcoinBAASBillet::BILLET_URL,
                ) => self::successCreateBilletStub(),
            ],
        );

        $billet = new CelcoinBAASBillet();
        $result = $billet->createBillet($this->billetBodyRequest());

        $this->assertEquals('SUCCESS', $result['status']);
        $this->assertEquals('ce9b8d9b-0617-42e1-b500-80bf9d8154cf', $result['body']['transactionId']);
    }

    public static function billetBodyRequest(): Billet
    {
        return new Billet([
            'externalId' => 'externalId1',
            'expirationAfterPayment' => 1,
            'dueDate' => now()->format('Y-m-d'),
            'amount' => 12.5,
            'debtor' => new BilletDebtor([
                'name' => 'João teste de teste',
                'document' => '12345678910',
                'postalCode' => '06463035',
                'publicArea' => "Rua Mãe D'Água",
                'complement' => null,
                'number' => '1004',
                'neighborhood' => 'Jardim Mutinga',
                'city' => 'Barueri',
                'state' => 'SP',
            ]),
            'receiver' => new BilletReceiver([
                'document' => '12345678910',
                'account' => '30023646056263',
            ]),
        ]);
    }

    public static function successCreateBilletStub(): PromiseInterface
    {
        return Http::response([
            'version' => '1.0.0',
            'status' => 'SUCCESS',
            'body' => [
                'transactionId' => 'ce9b8d9b-0617-42e1-b500-80bf9d8154cf',
            ],
        ]);
    }

    public function testGetBillet()
    {
        $fake = fake('pt_BR');
        Http::fake(
            [
                config('celcoin.login_url') => GlobalStubs::loginResponse(),
                sprintf(
                    '%s%s',
                    config('api_url'),
                    CelcoinBAASBillet::BILLET_URL.'*',
                ) => self::successGetBilletStub(),
            ],
        );

        $billet = new CelcoinBAASBillet();
        $result = $billet->getBillet('ce9b8d9b-0617-42e1-b500-80bf9d8154cf');

        $this->assertEquals('SUCCESS', $result['status']);
        $this->assertEquals('ce9b8d9b-0617-42e1-b500-80bf9d8154cf', $result['body']['transactionId']);

    }

    public function successGetBilletStub(): PromiseInterface
    {
        return Http::response([
            'version' => '1.0.0',
            'status' => 'SUCCESS',
            'body' => [
                'transactionId' => 'ce9b8d9b-0617-42e1-b500-80bf9d8154cf',
                'externalId' => 'externalId1',
                'amount' => 12.5,
                'amountConfirmed' => 13,
                'duedate' => '2023-12-30',
                'status' => 'CONFIRMED',
                'debtor' => [
                    'name' => $this->faker->name,
                    'document' => $this->faker->numerify('###########'),
                    'postalCode' => '06463035',
                    'publicArea' => "Rua Mãe D'Água",
                    'number' => '1004',
                    'complement' => 'Apto 123',
                    'neighborhood' => 'Jardim Mutinga',
                    'city' => 'Barueri',
                    'state' => 'SP',
                ],
                'receiver' => [
                    'name' => 'Emilly Malu Tereza Sales',
                    'document' => $this->faker->numerify('###########'),
                    'postalCode' => '06474070',
                    'publicArea' => 'Alameda França',
                    'city' => 'Barueri',
                    'state' => 'SP',
                    'account' => '30023646056263',
                ],
                'instructions' => [
                    'fine' => 10,
                    'interest' => 5,
                    'discount' => [
                        'amount' => 1,
                        'modality' => 'fixed',
                        'limitDate' => '2023-12-20T00:00:00.0000000',
                    ],
                ],
                'boleto' => [
                    'transactionId' => '32290',
                    'status' => 'Pago',
                    'bankEmissor' => 'santander',
                    'bankNumber' => '4000178961',
                    'bankAgency' => '1004',
                    'bankAccount' => '0220060',
                    'barCode' => '03392942700000009009022006000040001789610101',
                    'bankLine' => '03399022070600004000317896101015294270000000900',
                    'bankAssignor' => 'CELCOIN INSTITUIÇÃO DE PAGAMENTO - SA',
                ],
                'pix' => [
                    'transactionId' => '817885753',
                    'transactionIdentification' => '817885753',
                    'status' => 'Cancelado',
                    'key' => 'teste@chavepix.com.br',
                    'emv' => '00020101021226980014br.gov.bcb.pix2576api-h.developer.btgpactual.com/pc/p/v2/cobv/303928a7b4034de09fddec6d1258c15d5204000053039865802BR5910Merle Yost6008Orinside61080863968162070503***6304D7D3',
                ],
                'split' => [
                    [
                        'amount' => 5,
                        'account' => '40655847871',
                    ],
                ],
            ],
        ]);
    }

    /**
     * @throws RequestException
     */
    public function testFailedCreateBillet()
    {
        Http::fake(
            [
                config('celcoin.login_url') => GlobalStubs::loginResponse(),
                sprintf(
                    '%s%s',
                    config('api_url'),
                    CelcoinBAASBillet::BILLET_URL.'*',
                ) => self::failedBilletStub(),
            ],
        );

        $this->expectException(Exception::class);
        $billet = new CelcoinBAASBillet();
        $billet->createBillet(self::billetBodyRequest());
    }

    public static function failedBilletStub(): PromiseInterface
    {
        return Http::response([
            'version' => '1.0.0',
            'status' => 'ERROR',
            'error' => [
                'errorCode' => 'CBE001',
                'message' => 'Ocorreu um erro interno durante a chamada da api.',
            ],
        ], 401);
    }

    /**
     * @throws RequestException
     */
    public function testSuccessDeleteBillet()
    {
        Http::fake(
            [
                config('celcoin.login_url') => GlobalStubs::loginResponse(),
                sprintf(
                    '%s%s',
                    config('api_url'),
                    CelcoinBAASBillet::BILLET_URL.'*',
                ) => self::successCreateBilletStub(),
            ],
        );

        $billet = new CelcoinBAASBillet();
        $result = $billet->cancelBillet('ce9b8d9b-0617-42e1-b500-80bf9d8154cf');
        $this->assertEquals('SUCCESS', $result['status']);
        $this->assertEquals('ce9b8d9b-0617-42e1-b500-80bf9d8154cf', $result['body']['transactionId']);
    }
}
