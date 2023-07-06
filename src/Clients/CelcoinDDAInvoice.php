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
    const REGISTER_ENDPOINT = '/dda-serviceinvoice-webservice/v1/invoice/register';

    public function register(RegisterInvoice $data)
    {
        $body = Validator::validate($data->toArray(), DDARegisterInvoice::rules());
        return $this->post(
            self::REGISTER_ENDPOINT,
            $body
        );
    }
}
