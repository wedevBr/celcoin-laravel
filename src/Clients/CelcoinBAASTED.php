<?php

namespace WeDevBr\Celcoin\Clients;

use Illuminate\Support\Facades\Validator;
use WeDevBr\Celcoin\Common\CelcoinBaseApi;
use WeDevBr\Celcoin\Rules\BAAS\TEDTransfer as BAASTEDTransfer;
use WeDevBr\Celcoin\Types\BAAS\TEDTransfer;

/**
 * Class CelcoinBAASTED
 * API de BaaS possui o modulo de TED, esse modulo contempla os seguintes serviços Transferência via TED e Consultar Status de uma Transferência TED
 * @package WeDevBr\Celcoin
 */
class CelcoinBAASTED extends CelcoinBaseApi
{
    const TRANSFER_ENDPOINT = '/baas-wallet-transactions-webservice/v1/spb/transfer';
    const GET_STATUS_TRANSFER_ENDPOINT = '/baas-wallet-transactions-webservice/v1/spb/transfer/status';

    public function transfer(TEDTransfer $data)
    {
        $body = Validator::validate($data->toArray(), BAASTEDTransfer::rules());
        return $this->post(
            self::TRANSFER_ENDPOINT,
            $body
        );
    }

    public function getStatusTransfer(?string $id = null, ?string $clientCode = null)
    {
        return $this->get(
            self::GET_STATUS_TRANSFER_ENDPOINT,
            [
                'id' => $id,
                'clientCode' => $clientCode,
            ]
        );
    }
}
