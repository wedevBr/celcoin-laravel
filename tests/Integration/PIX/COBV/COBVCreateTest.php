<?php

namespace WeDevBr\Celcoin\Tests\Integration\PIX\COBV;

use GuzzleHttp\Promise\PromiseInterface;
use Illuminate\Http\Client\RequestException;
use Illuminate\Support\Facades\Http;
use Symfony\Component\HttpFoundation\Response;
use WeDevBr\Celcoin\Clients\CelcoinPIXCOBV;
use WeDevBr\Celcoin\Enums\AmountDiscountModalityTypeEnum;
use WeDevBr\Celcoin\Tests\GlobalStubs;
use WeDevBr\Celcoin\Tests\TestCase;
use WeDevBr\Celcoin\Types\PIX\AmountDicount;
use WeDevBr\Celcoin\Types\PIX\COBV;
use WeDevBr\Celcoin\Types\PIX\Debtor;
use WeDevBr\Celcoin\Types\PIX\DiscountDateFixed;
use WeDevBr\Celcoin\Types\PIX\Receiver;

class COBVCreateTest extends TestCase
{
    /**
     * @throws RequestException
     */
    final public function testCreateCobv(): void
    {
        Http::fake(
            [
                config('celcoin.login_url') => GlobalStubs::loginResponse(),
                CelcoinPIXCOBV::CREATE_COBV_PIX => self::stubSuccess(),
            ],
        );
        $pixCOBV = new CelcoinPIXCOBV();
        $result = $pixCOBV->createCOBVPIX(self::fakeCOBVBody());
        $this->assertEquals('ACTIVE', $result['status']);
        $this->assertEquals(15.63, $result['amount']['original']);
    }

    private static function stubSuccess(): PromiseInterface
    {
        return Http::response([
            'transactionIdentification' => 'kk6g232xel65a0daee4dd13kk9189382',
            'transactionId' => 9189382,
            'clientRequestId' => '9b26edb7cf254db09f5449c94bf13abc',
            'status' => 'ACTIVE',
            'lastUpdate' => '2022-03-21T14:27:58.2106288+00:00',
            'payerQuestion' => null,
            'additionalInformation' => null,
            'debtor' => [
                'name' => 'Fulano de Tal',
                'cpf' => null,
                'cnpj' => '61360961000100',
            ],
            'amount' => [
                'original' => 15.63,
                'discount' => [
                    'discountDateFixed' => [
                        [
                            'date' => '2022-03-21T00:00:00',
                            'amountPerc' => '1.00',
                        ],
                    ],
                    'modality' => 'FIXED_VALUE_UNTIL_THE_DATES_INFORMED',
                ],
                'abatement' => null,
                'fine' => null,
                'interest' => null,
            ],
            'location' => [
                'merchant' => [
                    'postalCode' => '01201005',
                    'city' => 'Barueri',
                    'merchantCategoryCode' => '0000',
                    'name' => 'Celcoin Pagamentos',
                ],
                'url' => 'api-h.developer.btgpactual.com/v1/p/v2/cobv/8767107ce1db49fdb1058224e00c4ab1',
                'emv' => '00020101021226980014br.gov.bcb.pix2576api-h.developer.btgpactual.com/v1/p/v2/cobv/8767107ce1db49fdb1058224e00c4ab15204000053039865802BR5918Celcoin Pagamentos6007Barueri61080120100562070503***630411F9',
                'type' => 'COBV',
                'locationId' => '55845',
                'id' => null,
            ],
            'key' => 'testepix@celcoin.com.br',
            'receiver' => [
                'name' => 'João da Silva',
                'fantasyName' => 'Nome de Comercial',
                'cpf' => null,
                'cnpj' => '60904237000129',
            ],
            'calendar' => [
                'expirationAfterPayment' => '10',
                'createdAt' => '0001-01-01T00:00:00',
                'dueDate' => '2022-03-22T00:00:00',
            ],
            'createAt' => '2022-03-21T14:27:58.2106288+00:00',
        ], Response::HTTP_OK);
    }

    private function fakeCOBVBody(): COBV
    {
        $cobv = new COBV([
            'clientRequestId' => '9b26edb7cf254db09f5449c94bf13abc',
            'expirationAfterPayment' => 30,
            'duedate' => '2023-08-29 00:00:00',
            'amount' => 15.63,
            'key' => 'testepix@celcoin.com.br',
        ]);
        $cobv->debtor = new Debtor([
            'name' => 'Fulano de Tal',
            'cnpj' => '61360961000100',
            'city' => 'Barueri',
            'publicArea' => 'Avenida Brasil',
            'state' => 'SP',
            'postalCode' => '01202003',
            'email' => 'contato@celcoin.com.br',
        ]);
        $cobv->receiver = new Receiver([
            'name' => 'João da Silva',
            'cnpj' => '60904237000129',
            'postalCode' => '01202003',
            'city' => 'Barueri',
            'publicArea' => 'Avenida Brasil',
            'state' => 'SP',
            'fantasyName' => 'Nome de Comercial',
        ]);

        return $cobv;
    }

    /**
     * @throws RequestException
     */
    public function testDueDateLessCurrentDateError()
    {
        Http::fake(
            [
                config('celcoin.login_url') => GlobalStubs::loginResponse(),
                CelcoinPIXCOBV::CREATE_COBV_PIX => self::stubDueDateLessCurrentDate(),
            ],
        );
        $pixCOBV = new CelcoinPIXCOBV();
        $cobv = self::fakeCOBVBody();
        $cobv->duedate = '2021-09-05 00:00:00';

        $this->expectException(RequestException::class);
        $pixCOBV->createCOBVPIX($cobv);
    }

    private static function stubDueDateLessCurrentDate(): PromiseInterface
    {
        return Http::response([
            'message' => 'The Calendar.DueDate field cannot be less than the current date.',
            'errorCode' => 'PCE003',
        ], Response::HTTP_BAD_REQUEST);
    }

    public function testDiscountDateFixedLessCurrentDateError()
    {
        Http::fake(
            [
                config('celcoin.login_url') => GlobalStubs::loginResponse(),
                CelcoinPIXCOBV::CREATE_COBV_PIX => self::stubDiscountDateFixedLessCurrentDate(),
            ],
        );
        $pixCOBV = new CelcoinPIXCOBV();
        $cobv = self::fakeCOBVBody();
        $cobv->amountDicount = new AmountDicount([
            'discountDateFixed' => [
                new DiscountDateFixed([
                    'date' => '2021-04-29',
                    'amountPerc' => '1.00',
                ]),
            ],
            'hasDiscount' => true,
            'modality' => AmountDiscountModalityTypeEnum::AMOUNT_PER_CALENDAR_DAY_ADVANCE->value,
            'amountPerc' => '0.5',

        ]);
        $this->expectException(RequestException::class);
        $pixCOBV->createCOBVPIX($cobv);
    }

    private static function stubDiscountDateFixedLessCurrentDate(): PromiseInterface
    {
        return Http::response([
            'message' => 'The Discount.DiscountDateFixed.AmountPerc field cannot be less than the current date.',
            'errorCode' => 'PCE003',
        ], Response::HTTP_BAD_REQUEST);
    }

    public function testPixCollectionForSameLocationError()
    {
        Http::fake(
            [
                config('celcoin.login_url') => GlobalStubs::loginResponse(),
                CelcoinPIXCOBV::CREATE_COBV_PIX => self::stubPixCollectionForSameLocation(),
            ],
        );
        $pixCOBV = new CelcoinPIXCOBV();
        $cobv = self::fakeCOBVBody();
        $cobv->locationId = 55845;
        $this->expectException(RequestException::class);
        $pixCOBV->createCOBVPIX($cobv);
    }

    private static function stubPixCollectionForSameLocation(): PromiseInterface
    {
        return Http::response([
            'message' => "Can't create a new PixCollectionDueDate when there is another Pix Collection active with the same location.",
            'errorCode' => 'PBE318',
        ], Response::HTTP_BAD_REQUEST);
    }
}
