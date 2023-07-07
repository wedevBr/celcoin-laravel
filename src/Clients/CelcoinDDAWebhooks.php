<?php

namespace WeDevBr\Celcoin\Clients;

use Illuminate\Support\Facades\Validator;
use WeDevBr\Celcoin\Common\CelcoinBaseApi;
use WeDevBr\Celcoin\Rules\DDA\RegisterWebhooks as DDARegisterWebhooks;
use WeDevBr\Celcoin\Types\DDA\RegisterWebhooks;

/**
 * Class CelcoinWebhooks
 * Depois que uma solicitação é enviada, ela passa por vários status. Toda vez que essa alteração ocorre, um webhook é acionado para que o originador possa manter o controle do processo de originação.
 * @package WeDevBr\Celcoin
 */
class CelcoinDDAWebhooks extends CelcoinBaseApi
{

    const REGISTER_ENDPOINT = '/dda-servicewebhook-webservice/v1/webhook/register';
    const LIST_ENDPOINT = '/dda-servicewebhook-webservice/v1/webhook/routes';

    public function register(RegisterWebhooks $data)
    {
        $body = Validator::validate($data->toArray(), DDARegisterWebhooks::rules());
        return $this->post(
            self::REGISTER_ENDPOINT,
            $body
        );
    }

    public function list()
    {
        return $this->get(self::LIST_ENDPOINT);
    }
}
