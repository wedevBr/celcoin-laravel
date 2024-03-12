<?php

namespace WeDevBr\Celcoin\Tests\Integration\PIX\COBV;

use Closure;
use GuzzleHttp\Promise\PromiseInterface;
use Illuminate\Http\Client\RequestException;
use Illuminate\Support\Facades\Http;
use Symfony\Component\HttpFoundation\Response;
use WeDevBr\Celcoin\Clients\CelcoinPIXCOBV;
use WeDevBr\Celcoin\Tests\GlobalStubs;
use WeDevBr\Celcoin\Tests\TestCase;
use WeDevBr\Celcoin\Types\PIX\AdditionalInformation;
use WeDevBr\Celcoin\Types\PIX\Calendar;
use WeDevBr\Celcoin\Types\PIX\COBV;
use WeDevBr\Celcoin\Types\PIX\Debtor;

class COBVUpdateTest extends TestCase
{

    /**
     * @throws RequestException
     */
    final public function testUpdateCobv(): void
    {
        $transactionId = 123456;
        Http::fake(
            [
                config('celcoin.login_url') => GlobalStubs::loginResponse(),
                sprintf(CelcoinPIXCOBV::UPDATE_COBV_PIX, $transactionId) => self::stubSuccess(),
            ],
        );
        $pixCOB = new CelcoinPIXCOBV();
        $result = $pixCOB->updateCOBVPIX($transactionId, self::fakeCOBVBody()->toArray());
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
                'cpf' => null,
                'cnpj' => '00190305000103',
            ],
            'amount' => [
                'original' => 15.01,
                'changeType' => 0,
                'withdrawal' => null,
                'change' => null,
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
                'id' => null,
            ],
            'key' => 'testepix@celcoin.com.br',
            'calendar' => [
                'expiration' => 86400,
            ],
            'createAt' => '2023-06-26T22:36:23.4800282+00:00',
            'transactionIdentification' => 'kk6g232xel65a0daee4dd13kk817849685',
        ], Response::HTTP_OK);
    }

    private function fakeCOBVBody(): COBV
    {
        $cobv = new COBV([
            'clientRequestId' => '14232341231',
            'payerQuestion' => 'Não pagável após vencimento.',
            'key' => 'testepix@celcoin.com.br',
            'locationId' => 1234567,
        ]);
        $cobv->debtor = new Debtor([
            'name' => 'Fulano de Tal',
            'cnpj' => '61360961000100',
        ]);
        $cobv->additionalInformation[] = new AdditionalInformation(
            [
                'value' => 'Assinatura de serviço',
                'key' => 'Produto 1',
            ],
        );
        $cobv->amount = 15.01;
        $cobv->calendar = new Calendar([
            'expiration' => 84000,
        ]);
        return $cobv;
    }

    /**
     * @dataProvider updateCobvErrorDataProvider
     */
    final public function testUpdateCobvError(Closure $response, string $error, string $key): void
    {
        $transactionId = 123456;
        Http::fake(
            [
                config('celcoin.login_url') => GlobalStubs::loginResponse(),
                sprintf(CelcoinPIXCOBV::UPDATE_COBV_PIX, $transactionId) => $response,
            ],
        );

        $this->expectException(RequestException::class);
        try {
            $pixCOB = new CelcoinPIXCOBV();
            $pixCOB->updateCOBVPIX($transactionId, self::fakeCOBVBody()->toArray());
        } catch (RequestException $exception) {
            $result = $exception->response->json();
            $this->assertEquals($error, $result[$key]);
            throw $exception;
        }
    }

    public static function updateCobvErrorDataProvider(): array
    {
        return [
            'wrong calendar due date' => [
                fn() => self::getCalendarDueDateErrorResponse(),
                'PCE003',
                'errorCode',
            ],
            'wrong discount amount perc' => [
                fn() => self::getDiscountAmountPercErrorResponse(),
                'PCE003',
                'errorCode',
            ],
            'wrong pix collection error' => [
                fn() => self::getCanNotCreateNewPixCollectionDueDateErrorResponse(),
                'PBE318',
                'errorCode',
            ],
        ];
    }

    private static function getCalendarDueDateErrorResponse(): PromiseInterface
    {
        $data = [
            'message' => 'The Calendar.DueDate field cannot be less than the current date.',
            'errorCode' => 'PCE003',
        ];

        return Http::response($data, Response::HTTP_BAD_REQUEST);
    }

    private static function getDiscountAmountPercErrorResponse(): PromiseInterface
    {
        $data = [
            'message' => 'The Discount.DiscountDateFixed.AmountPerc field cannot be less than the current date.',
            'errorCode' => 'PCE003',
        ];

        return Http::response($data, Response::HTTP_BAD_REQUEST);
    }

    private static function getCanNotCreateNewPixCollectionDueDateErrorResponse(): PromiseInterface
    {
        $data = [
            'message' => 'Can\'t create a new Pix Collection when there is another Pix Collection active with the same location.',
            'errorCode' => 'PBE318',
        ];

        return Http::response($data, Response::HTTP_BAD_REQUEST);
    }

}
