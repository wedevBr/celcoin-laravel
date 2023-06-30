<?php

namespace Tests\Integration\PIX\COB;

use Closure;
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
    final public function testCreateCobWithCobvLocation(): void
    {
        Http::fake(
            [
                config('celcoin.login_url') => GlobalStubs::loginResponse(),
                CelcoinPIXCOB::CREATE_COB_PIX_URL => self::stubCOBError(),
            ]
        );
        $this->expectException(RequestException::class);

        try {
            $pixCOB = new CelcoinPIXCOB();
            $pixCOB->createCOBPIX(self::fakeCOBBody());
        } catch (RequestException $exception) {
            $result = $exception->response->json();
            $this->assertEquals('PBE410', $result['errorCode']);
            $this->assertEquals('Can\'t create a new PixImmediateCollection when the location type is COB', $result['message']);
            throw $exception;
        }
    }

    private static function stubCOBError(): PromiseInterface
    {
        return Http::response([
            'message' => 'Can\'t create a new PixImmediateCollection when the location type is COB',
            'errorCode' => 'PBE410'
        ],
            Response::HTTP_BAD_REQUEST
        );
    }

    /**
     * @throws RequestException
     * @dataProvider createErrorDataProvider
     */
    final public function testCreateCobWithoutField(string $unsetValue, array $validation): void
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

        try {
            $pixCOB->createCOBPIX($cob);
        } catch (ValidationException $exception) {
            $this->assertArrayHasKey($unsetValue, $exception->errors());
            throw $exception;
        }

    }

    /**
     * @throws RequestException
     * @dataProvider statusErrorDataProvider
     */
    final public function testCreateErrors(
        Closure $response,
        string  $errorCode,
        string  $errorCodeKey = 'errorCode'
    ): void
    {
        Http::fake(
            [
                config('celcoin.login_url') => GlobalStubs::loginResponse(),
                CelcoinPIXCOB::CREATE_COB_PIX_URL => $response,
            ]
        );
        $pixCOB = new CelcoinPIXCOB();

        $this->expectException(RequestException::class);

        try {
            $cob = self::fakeCOBBody();
            $pixCOB->createCOBPIX($cob);
        } catch (RequestException $exception) {
            $response = $exception->response->json();
            $this->assertEquals($errorCode, $response[$errorCodeKey]);
            throw $exception;
        }

    }

    final public function createErrorDataProvider(): array
    {
        return [
            'required amount' => ['amount', ['attribute' => 'amount']],
            'required amount original' => ['amount', ['attribute' => 'amount.original']],
            'required clientRequestId' => ['clientRequestId', ['attribute' => 'clientRequestId']],
            'required key' => ['key', ['attribute' => 'key']],
            'required locationId' => ['locationId', ['attribute' => 'locationId', 'integer']],
            'required debtor' => ['debtor', ['attribute' => 'debtor', 'integer']],
            'required debtor name' => ['debtor', ['attribute' => 'debtor.name', 'string']],
            'required debtor cpf' => ['debtor', ['attribute' => 'debtor.cpf', 'required_without:debtor.cnpj']],
            'required debtor cnpj' => ['debtor', ['attribute' => 'debtor.cnpj', 'required_without:debtor.cpf']],
            'required calendar' => ['calendar', ['attribute' => 'calendar', 'array']],
            'required calendar expiration' => ['calendar', ['attribute' => 'calendar.expiration', 'integer']],
        ];
    }

    final public function statusErrorDataProvider(): array
    {
        return [
            'PBE318' => [fn() => self::locationInUseStub(), 'PBE318'],
            'CI002' => [fn() => self::locationNotReturned(), 'CI002'],
            'CI003' => [fn() => self::keyNotRegistered(), 'CI003'],
            'VLI001' => [fn() => self::originalAmountIsRequired(), 'VLI001'],
            'VLI002' => [fn() => self::prohibitSimultaneousSendChangeAndWithdrawal(), 'VLI002'],
            'VLI010' => [fn() => self::cashValueIsMandatory(), 'VLI010'],
            'VLI004' => [fn() => self::testWithdrawalAmountOriginalGreaterThanZero(), 'VLI004'],
            'VLI005' => [fn() => self::testWithdrawalAmountOriginalNotGreaterThanZero(), 'VLI005'],
            'VLI006' => [fn() => self::testWithdrawalIspbCodePattern(), 'VLI006'],
            'VLI007' => [fn() => self::testWithdrawalAgentModeRequired(), 'VLI007'],
            'VLI008' => [fn() => self::testWithdrawalAgentModeValidOptions(), 'VLI008'],
            'VLI009' => [fn() => self::testWithdrawalRequiredCashValue(), 'VLI009'],
        ];
    }

    private function locationInUseStub(): PromiseInterface
    {
        return Http::response(
            [
                'message' => 'Can\'t create a new Pix Collection when there is another Pix Collection active with the same location.',
                'errorCode' => 'PBE318'
            ],
            Response::HTTP_BAD_REQUEST
        );
    }

    private function locationNotReturned(): PromiseInterface
    {
        return Http::response(
            [
                'message' => 'Não foi retornado BRCode Location.',
                'errorCode' => 'CI002'
            ],
            Response::HTTP_BAD_REQUEST
        );
    }

    private function keyNotRegistered(): PromiseInterface
    {
        return Http::response(
            [
                'message' => 'Chave informada não cadastrada',
                'errorCode' => 'CI003'
            ],
            Response::HTTP_BAD_REQUEST
        );
    }

    private function originalAmountIsRequired(): PromiseInterface
    {
        return Http::response(
            [
                'message' => 'O valor original é obrigatório neste tipo de transação',
                'errorCode' => 'VLI001'
            ],
            Response::HTTP_BAD_REQUEST
        );
    }

    private function prohibitSimultaneousSendChangeAndWithdrawal(): PromiseInterface
    {
        return Http::response(
            [
                'message' => 'Não é permitido preencher os objetos \'change\' e \'withdrawal\' simultaneamente',
                'errorCode' => 'VLI002'
            ],
            Response::HTTP_BAD_REQUEST
        );
    }

    private function cashValueIsMandatory(): PromiseInterface
    {
        return Http::response(
            [
                // TODO(aronpc): verificar se existe um espaço na frente do valor " Valor..."
                'message' => 'Valor em dinheiro disponibilizado é obrigatório neste tipo de transação',
                'errorCode' => 'VLI010'
            ],
            Response::HTTP_BAD_REQUEST
        );
    }

    private function testWithdrawalAmountOriginalGreaterThanZero(): PromiseInterface
    {
        return Http::response(
            [
                'message' => 'O valor \'Amount.Original\' não pode ser maior que 0 quando o tipo de transação é WITHDRAWAL.',
                'errorCode' => 'VLI004'
            ],
            Response::HTTP_BAD_REQUEST
        );
    }

    private function testWithdrawalAmountOriginalNotGreaterThanZero(): PromiseInterface
    {
        return Http::response(
            [
                'message' => 'O valor \'Amount.Original\' não pode ser maior que 0 quando o tipo de transação é WITHDRAWAL.',
                'errorCode' => 'VLI005'
            ],
            Response::HTTP_BAD_REQUEST
        );
    }

    private function testWithdrawalIspbCodePattern(): PromiseInterface
    {
        return Http::response(
            [
                // TODO(aronpc): verificar se existe um espaço na frente do valor " O código..."
                'message' => 'O código de ISPB em operações de saque está fora do padrão \'[0-9]{8}\'.',
                'errorCode' => 'VLI006'
            ],
            Response::HTTP_BAD_REQUEST
        );
    }

    private function testWithdrawalAgentModeRequired(): PromiseInterface
    {
        return Http::response(
            [
                'message' => 'O modo de agente de saque é obrigatório neste tipo de transação',
                'errorCode' => 'VLI007'
            ],
            Response::HTTP_BAD_REQUEST
        );
    }

    private function testWithdrawalAgentModeValidOptions(): PromiseInterface
    {
        return Http::response(
            [
                'message' => 'O modo de agente de saque deve ser um dos seguinte: AGTEC, AGTOT ou AGPSS',
                'errorCode' => 'VLI008'
            ],
            Response::HTTP_BAD_REQUEST
        );
    }

    private function testWithdrawalRequiredCashValue(): PromiseInterface
    {
        return Http::response(
            [
                'message' => 'Valor em dinheiro disponibilizado é obrigatório neste tipo de transação',
                'errorCode' => 'VLI009'
            ],
            Response::HTTP_BAD_REQUEST
        );
    }

}