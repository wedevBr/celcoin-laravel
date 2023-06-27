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

class COBCreateTest extends TestCase
{

    /**
     * @throws RequestException
     */
    final public function testCreateCob(): void
    {
        Http::fake(
            [
                config('celcoin.login_url') => GlobalStubs::loginResponse(),
                CelcoinPIXCOB::CREATE_COB_PIX_URL => self::stubSuccess(),
            ]
        );
        $pixCOB = new CelcoinPIXCOB();
        $result = $pixCOB->createCOBPIX(self::fakeCOBBody());
        $this->assertEquals('ACTIVE', $result['status']);
        $this->assertEquals(15.63, $result['amount']['original']);
    }

    private static function stubSuccess(): PromiseInterface
    {
        return Http::response([
            'revision' => 0,
            'transactionId' => 817849685,
            'clientRequestId' => '14232341231',
            'status' => 'ACTIVE',
            'lastUpdate' => '2023-06-26T22:36:23.4800282+00:00',
            'payerQuestion' => 'Não pagável após vencimento.',
            'additionalInformation' => [
                [
                    'value' => 'Assinatura de serviço',
                    'key' => 'Produto 1',
                ],
            ],
            'debtor' => [
                'name' => 'Fulano de Tal',
                'cpf' => NULL,
                'cnpj' => '00190305000103',
            ],
            'amount' => [
                'original' => 15.63,
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
                'locationId' => '13043812',
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
            "cnpj" => "61360961000100",
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
    final public function testCreateCobWithCobvLocation(): void
    {
        Http::fake(
            [
                config('celcoin.login_url') => GlobalStubs::loginResponse(),
                CelcoinPIXCOB::CREATE_COB_PIX_URL => self::stubCOBVError(),
            ]
        );
        $this->expectException(RequestException::class);

        $pixCOB = new CelcoinPIXCOB();
        $result = $pixCOB->createCOBPIX(self::fakeCOBBody());

        $this->assertEquals('PBE410', $result['errorCode']);
        $this->assertEquals("Can't create a new PixImmediateCollection when the location type is COBV", $result['message']);

    }

    private static function stubCOBVError(): PromiseInterface
    {
        return Http::response([
            "message" => "Can't create a new PixImmediateCollection when the location type is COBV",
            "errorCode" => "PBE410"
        ],
            Response::HTTP_BAD_REQUEST
        );
    }

    /**
     * @throws RequestException
     * @dataProvider errorDataProvider
     */
    final public function testCreateCobWithoutAmount(string $unsetValue, array $validation): void
    {
        Http::fake(
            [
                config('celcoin.login_url') => GlobalStubs::loginResponse(),
                CelcoinPIXCOB::CREATE_COB_PIX_URL => self::stubSuccess(),
            ]
        );
        $pixCOB = new CelcoinPIXCOB();

        $cob = self::fakeCOBBody();

        unset($cob->$unsetValue);

        $this->expectException(ValidationException::class);
        $this->expectExceptionMessage(__('required', $validation));

        $pixCOB->createCOBPIX($cob);
    }


    final public function errorDataProvider(): array
    {
        return [
            'Assert Required amount' => ['amount', ['attribute' => 'amount']],
            'Assert Required amount original' => ['amount', ['attribute' => 'amount.original']],
            'Assert Required clientRequestId' => ['clientRequestId', ['attribute' => 'clientRequestId']],
            'Assert Required key' => ['key', ['attribute' => 'key']],
            'Assert Required locationId' => ['locationId', ['attribute' => 'locationId', 'integer']],
            'Assert Required debtor' => ['debtor', ['attribute' => 'debtor', 'integer']],
            'Assert Required debtor name' => ['debtor', ['attribute' => 'debtor.name', 'string']],
            'Assert Required debtor cpf' => ['debtor', ['attribute' => 'debtor.cpf', 'required_without:debtor.cnpj']],
            'Assert Required debtor cnpj' => ['debtor', ['attribute' => 'debtor.cnpj', 'required_without:debtor.cpf']],
            'Assert Required calendar' => ['calendar', ['attribute' => 'calendar', 'array']],
            'Assert Required calendar expiration' => ['calendar', ['attribute' => 'calendar.expiration', 'integer']],
        ];
    }

}