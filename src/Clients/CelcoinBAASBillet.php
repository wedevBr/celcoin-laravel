<?php

namespace WeDevBr\Celcoin\Clients;

use Illuminate\Http\Client\RequestException;
use Illuminate\Support\Facades\Validator;
use WeDevBr\Celcoin\Common\CelcoinBaseApi;
use WeDevBr\Celcoin\Rules\BAAS\Billet as BilletRules;
use WeDevBr\Celcoin\Types\BAAS\Billet;

class CelcoinBAASBillet extends CelcoinBaseApi
{
    const CREATE_BILLET_URL = '/api-integration-baas-webservice/v1/charge';
    const GET_BILLET_URL = '/api-integration-baas-webservice/v1/charge/%s';

    /**
     * @throws RequestException
     */
    public function createBillet(Billet $billet)
    {
        $data = Validator::validate($billet->toArray(), BilletRules::rules());
        return $this->post(self::CREATE_BILLET_URL, $data);
    }

    /**
     * @throws RequestException
     */
    public function getBillet($transaction_id = null, $external_id = null)
    {
        return $this->get(self::GET_BILLET_URL, [
            'transactionId' => $transaction_id,
            'externalId' => $external_id,
        ]);
    }
}