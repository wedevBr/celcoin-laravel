<?php

namespace WeDevBr\Celcoin\Clients;

use Illuminate\Support\Facades\Validator;
use WeDevBr\Celcoin\Common\CelcoinBaseApi;
use WeDevBr\Celcoin\Rules\BAAS\TEDTransfer as BAASTEDTransfer;
use WeDevBr\Celcoin\Types\BAAS\TEDTransfer;

/**
 * Class CelcoinBAASTED
 * API de BaaS possui o modulo de TED, esse modulo contempla os seguintes serviços:
 * @package WeDevBr\Celcoin
 */
class CelcoinBAASTED extends CelcoinBaseApi
{
    public function transfer(TEDTransfer $data)
    {
        $body = Validator::validate($data->toArray(), BAASTEDTransfer::rules());
        return $this->post(
            "/baas-wallet-transactions-webservice/v1/spb/transfer",
            $body
        );
    }

    public function getStatusTransfer(string $id, string $clientCode)
    {
        return $this->get(
            "/baas-wallet-transactions-webservice/v1/spb/transfer",
            [
                'id' => $id,
                'clientCode' => $clientCode,
            ]
        );
    }
}
