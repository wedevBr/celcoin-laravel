<?php

namespace WeDevBr\Celcoin\Clients;

use Carbon\Carbon;
use Illuminate\Http\Client\RequestException;
use Illuminate\Support\Facades\Validator;
use WeDevBr\Celcoin\Common\CelcoinBaseApi;
use WeDevBr\Celcoin\Rules\ElectronicTransactions\Deposit as ElectronicTransactionsDeposit;
use WeDevBr\Celcoin\Rules\ElectronicTransactions\ServicesPoints as ElectronicTransactionsServicesPoints;
use WeDevBr\Celcoin\Rules\ElectronicTransactions\Withdraw as ElectronicTransactionsWithdraw;
use WeDevBr\Celcoin\Rules\ElectronicTransactions\WithdrawToken as ElectronicTransactionsWithdrawToken;
use WeDevBr\Celcoin\Types\ElectronicTransactions\Deposit;
use WeDevBr\Celcoin\Types\ElectronicTransactions\ServicesPoints;
use WeDevBr\Celcoin\Types\ElectronicTransactions\Withdraw;
use WeDevBr\Celcoin\Types\ElectronicTransactions\WithdrawToken;

/**
 * Class CelcoinElectronicTransactions
 * Essa funcionalidade permite que sejam realizados depósitos, ou saques através de um Qrcode, ou token nos caixas 24 horas disponibilizados em mercados e postos de gasolina pela TechBan.
 * @package WeDevBr\Celcoin
 */
class CelcoinElectronicTransactions extends CelcoinBaseApi
{

    const GET_PARTNERS_ENDPOINT = '/v5/transactions/electronictransactions/consult-partners';
    const GET_SERVICES_POINTS_ENDPOINT = '/v5/transactions/electronictransactions/consult-servicespoints';
    const DEPOSIT_ENDPOINT = '/v5/transactions/electronictransactions/electronic-payment';
    const WITHDRAW_ENDPOINT = '/v5/transactions/electronictransactions/electronic-receipt';
    const GENERATE_WITHDRAW_TOKEN_ENDPOINT = '/v5/transactions/electronictransactions/withdraw-thirdparty';

    public function getPartners()
    {
        return $this->get(self::GET_PARTNERS_ENDPOINT);
    }

    /**
     * @return array|mixed
     * @throws RequestException
     */
    public function getServicesPoints(ServicesPoints $data)
    {
        $body = Validator::validate($data->toArray(), ElectronicTransactionsServicesPoints::rules());
        return $this->post(
            self::GET_SERVICES_POINTS_ENDPOINT,
            $body
        );
    }

    public function deposit(Deposit $data)
    {
        $body = Validator::validate($data->toArray(), ElectronicTransactionsDeposit::rules());
        return $this->post(
            self::DEPOSIT_ENDPOINT,
            $body
        );
    }

    public function withdraw(Withdraw $data)
    {
        $body = Validator::validate($data->toArray(), ElectronicTransactionsWithdraw::rules());
        return $this->post(
            self::WITHDRAW_ENDPOINT,
            $body
        );
    }

    public function generateWithdrawToken(WithdrawToken $data)
    {
        $body = Validator::validate($data->toArray(), ElectronicTransactionsWithdrawToken::rules());
        return $this->post(
            self::GENERATE_WITHDRAW_TOKEN_ENDPOINT,
            $body
        );
    }
}
