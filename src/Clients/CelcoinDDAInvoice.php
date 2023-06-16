<?php

namespace WeDevBr\Celcoin\Clients;

use Illuminate\Support\Facades\Validator;
use WeDevBr\Celcoin\Common\CelcoinBaseApi;
use WeDevBr\Celcoin\Rules\DDA\RegisterInvoice as DDARegisterInvoice;
use WeDevBr\Celcoin\Types\DDA\RegisterInvoice;

/**
 * Class CelcoinWebhooks
 * Essa API permite gerar boletos para um usuário cadastrado no DDA
 * @package WeDevBr\Celcoin
 */
class CelcoinDDAInvoice extends CelcoinBaseApi
{
    public function register(RegisterInvoice $data)
    {
        $body = Validator::validate($data->toArray(), DDARegisterInvoice::rules());
        return $this->post(
            "/dda-servicewebhook-webservice/v1/webhook/register",
            $body
        );
    }
}
