<?php

namespace WeDevBr\Celcoin\Clients;

use Carbon\Carbon;
use Illuminate\Support\Facades\Validator;
use WeDevBr\Celcoin\Common\CelcoinBaseApi;
use WeDevBr\Celcoin\Rules\BankTransfer\Create as BankTransferCreate;
use WeDevBr\Celcoin\Types\BankTransfer\Create;

/**
 * Class BankTransfer
 * Essa funcionalidade permite realizar transferências de forma online, fazendo com que o envio junto ao banco destino seja realizado imediatamente e o cliente receba o status desta transferência no mesmo instante.
 */
class CelcoinBankTransfer extends CelcoinBaseApi
{
    public const CREATE_ENDPOINT = '/v5/transactions/banktransfer';

    public const GET_STATUS_TRANSFER_ENDPOINT = '/v5/transactions/banktransfer/status-transfer/%d';

    public function create(Create $data)
    {
        $body = Validator::validate($data->toArray(), BankTransferCreate::rules());

        return $this->post(
            self::CREATE_ENDPOINT,
            $body
        );
    }

    public function getStatusTransfer(int $transactionId, ?int $nsuExterno = null, ?string $terminalIdExterno = null, ?Carbon $dataOperacao = null)
    {
        return $this->get(
            sprintf(self::GET_STATUS_TRANSFER_ENDPOINT, $transactionId),
            [
                'nsuExterno' => $nsuExterno,
                'terminalIdExterno' => $terminalIdExterno,
                'dataOperacao' => ! empty($dataOperacao) ? $dataOperacao->format('Y-m-d') : null,
            ]
        );
    }
}
