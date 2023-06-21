<?php

namespace WeDevBr\Celcoin\Clients;

use Illuminate\Support\Facades\Validator;
use WeDevBr\Celcoin\Common\CelcoinBaseApi;
use WeDevBr\Celcoin\Rules\DDA\RegisterWebhooks as DDARegisterWebhooks;
use WeDevBr\Celcoin\Types\DDA\RegisterWebhooks;

/**
 * Class CelcoinWebhooks
 * API de BaaS possui o modulo de Gerenciamento de Webhook, com esses serviços você consegue administrar suas rotas de Webhook sem precisar acionar o time da Celcoin
 * @package WeDevBr\Celcoin
 */
class CelcoinBAASWebhooks extends CelcoinBaseApi
{
    public function register(RegisterWebhooks $data)
    {
        $body = Validator::validate($data->toArray(), DDARegisterWebhooks::rules());
        return $this->post(
            "/dda-servicewebhook-webservice/v1/webhook/register",
            $body
        );
    }

    public function list()
    {
        return $this->get("/dda-servicewebhook-webservice/v1/webhook/routes");
    }
}
