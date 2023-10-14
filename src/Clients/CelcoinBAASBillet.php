<?php

namespace WeDevBr\Celcoin\Clients;

use Illuminate\Http\Client\RequestException;
use Illuminate\Support\Facades\Validator;
use WeDevBr\Celcoin\Common\CelcoinBaseApi;
use WeDevBr\Celcoin\Rules\BAAS\Billet as BilletRules;
use WeDevBr\Celcoin\Types\BAAS\Billet;

class CelcoinBAASBillet extends CelcoinBaseApi
{
    const BILLET_URL = '/api-integration-baas-webservice/v1/charge';


    /**
     * @throws RequestException
     */
    public function createBillet(Billet $billet)
    {
        $data = Validator::validate($billet->toArray(), BilletRules::rules());
        return $this->post(self::BILLET_URL, $data);
    }

    /**
     * @throws RequestException
     */
    public function getBillet($transaction_id = null, $external_id = null)
    {
        $body = collect([
            'transactionId' => $transaction_id,
            'externalId' => $external_id,
        ])->filter()->toArray();
        return $this->get(self::BILLET_URL, $body);
    }

    /**
     * @throws RequestException
     */
    public function cancelBillet($transactionId)
    {
        return $this->delete(sprintf('%s/%s', self::BILLET_URL, $transactionId));
    }
}