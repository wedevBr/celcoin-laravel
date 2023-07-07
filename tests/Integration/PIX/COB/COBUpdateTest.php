<?php

namespace Tests\Integration\PIX\COB;

use GuzzleHttp\Promise\PromiseInterface;
use Illuminate\Http\Client\RequestException;
use Illuminate\Support\Facades\Http;
use Illuminate\Validation\ValidationException;
use Symfony\Component\HttpFoundation\Response;
use Tests\GlobalStubs;
use Tests\TestCase;
use WeDevBr\Celcoin\Clients\CelcoinPIXCOB;
use WeDevBr\Celcoin\Types\PIX\AdditionalInformation;
use WeDevBr\Celcoin\Types\PIX\Amount;
use WeDevBr\Celcoin\Types\PIX\Calendar;
use WeDevBr\Celcoin\Types\PIX\COB;
use WeDevBr\Celcoin\Types\PIX\Debtor;

class COBUpdateTest extends TestCase
{

    /**
     * @throws RequestException
     */
    final public function testUpdateCob(): void
    {
        $transactionId = 123456;
        Http::fake(
            [
                config('celcoin.login_url') => GlobalStubs::loginResponse(),
                sprintf(CelcoinPIXCOB::UPDATE_COB_PIX_URL, $transactionId) => self::stubSuccess(),
            ]
        );
        $pixCOB = new CelcoinPIXCOB();
        $result = $pixCOB->updateCOBPIX($transactionId, self::fakeCOBBody());
        $this->assertEquals('ACTIVE', $result['status']);
        $this->assertEquals(15.01, $result['amount']['original']);
    }

    private static function stubSuccess(): PromiseInterface
    {
        return Http::response([
            'revision' => 1,
            'transactionId' => 817849685,
            'clientRequestId' => '9b26ed7cf254db09f5449c94bf13abc',
            'status' => 'ACTIVE',
            'lastUpdate' => '2023-06-26T22:38:14.9306816+00:00',
            'payerQuestion' => 'Não pagável após vencimento',
            'additionalInformation' => [
                [
                    'value' => 'Assinatura de serviço',
                    'key' => 'Produto 1',
                ],
            ],
            'debtor' => [
                'name' => 'Fulano',
                'cpf' => NULL,
                'cnpj' => '00190305000103',
            ],
            'amount' => [
                'original' => 15.01,
                'changeType' => 0,
                'withdrawal' => NULL,
                'change' => NULL,
            ],
            'location' => [
                'merchant' => [
                    'postalCode' => '01201005',
                    'city' => 'Barueri',
                    'merchantCategoryCode' => '0000',
                    'name' => 'Celcoin Pagamentos',
                ],
                'url' => 'api-h.developer.btgpactual.com/pc/p/v2/1d53f8a4839641628b2d678f7ddb9ad6',
                'emv' => '00020101021226930014br.gov.bcb.pix2571api-h.developer.btgpactual.com/pc/p/v2/1d53f8a4839641628b2d678f7ddb9ad65204000053039865802BR5918Celcoin Pagamentos6007Barueri61080120100562070503***63040D56',
                'type' => 'COB',
                'locationId' => '0',
                'id' => NULL,
            ],
            'key' => 'testepix@celcoin.com.br',
            'calendar' => [
                'expiration' => 86400,
            ],
            'createAt' => '2023-06-26T22:36:23.4800282+00:00',
            'transactionIdentification' => 'kk6g232xel65a0daee4dd13kk817849685',
        ], Response::HTTP_OK);
    }

    private function fakeCOBBody(): COB
    {
        $cob = new COB([
            'clientRequestId' => '14232341231',
            'payerQuestion' => 'Não pagável após vencimento.',
            'key' => 'testepix@celcoin.com.br',
            'locationId' => 1234567,
        ]);
        $cob->debtor = new Debtor([
            'name' => 'Fulano de Tal',
            'cnpj' => '61360961000100',
        ]);
        $cob->additionalInformation[] = new AdditionalInformation(
            [
                'value' => 'Assinatura de serviço',
                'key' => 'Produto 1',
            ]
        );
        $cob->amount = new Amount([
            'original' => 15.63,
        ]);
        $cob->calendar = new Calendar([
            'expiration' => 84000,
        ]);
        return $cob;

    }

    /**
     * @throws RequestException
     */
    final public function testCreateCobWithCobLocation(): void
    {
        $transactionId = 123456;
        Http::fake(
            [
                config('celcoin.login_url') => GlobalStubs::loginResponse(),
                sprintf(CelcoinPIXCOB::UPDATE_COB_PIX_URL, $transactionId) => self::stubCOBError(),
            ]
        );
        $this->expectException(RequestException::class);

        try {
            $pixCOB = new CelcoinPIXCOB();
            $pixCOB->updateCOBPIX($transactionId, self::fakeCOBBody());
        } catch (RequestException $throwable) {
            $result = $throwable->response->json();
            $this->assertEquals('PBE318', $result['errorCode']);
            $this->assertEquals('Can\'t create a new Pix Collection when there is another Pix Collection active with the same location.', $result['message']);
            throw $throwable;
        }
    }

    private static function stubCOBError(): PromiseInterface
    {
        return Http::response([
            'message' => 'Can\'t create a new Pix Collection when there is another Pix Collection active with the same location.',
            'errorCode' => 'PBE318'
        ],
            Response::HTTP_BAD_REQUEST
        );
    }

    /**
     * @throws RequestException
     */
    final public function testUpdateCobDebtorRules(): void
    {
        [$transactionId, $pixCOB, $cob] = $this->cobObjectUpdate();

        $cob->debtor = new Debtor([]);

        $this->expectException(ValidationException::class);
        try {
            $pixCOB->updateCOBPIX($transactionId, $cob);
        } catch (ValidationException $throwable) {
            $this->assertArrayHasKey('debtor.cpf', $throwable->errors());
            $this->assertArrayHasKey('debtor.cnpj', $throwable->errors());
            throw $throwable;
        }
    }

    /**
     * @return array
     */
    final public function cobObjectUpdate(): array
    {
        $transactionId = 123456;
        Http::fake(
            [
                config('celcoin.login_url') => GlobalStubs::loginResponse(),
                sprintf(CelcoinPIXCOB::UPDATE_COB_PIX_URL, $transactionId) => self::stubCOBError(),
            ]
        );
        $pixCOB = new CelcoinPIXCOB();

        $cob = self::fakeCOBBody();
        return [$transactionId, $pixCOB, $cob];
    }

    /**
     * @throws RequestException
     */
    final public function testUpdateCobAdditionalInformationRules(): void
    {
        /**
         * @var $pixCOB CelcoinPIXCOB
         */
        [$transactionId, $pixCOB, $cob] = $this->cobObjectUpdate();

        unset($cob->additionalInformation);
        $cob->additionalInformation[] = new AdditionalInformation([
            'value' => 'valor'
        ]);
        $cob->additionalInformation[] = new AdditionalInformation([
            'key' => 'chage'
        ]);

        $this->expectException(ValidationException::class);
        try {
            $pixCOB->updateCOBPIX($transactionId, $cob);
        } catch (ValidationException $throwable) {
            $this->assertArrayHasKey('additionalInformation.1.value', $throwable->errors());
            $this->assertArrayHasKey('additionalInformation.0.key', $throwable->errors());
            throw $throwable;
        }
    }
}
