<?php

namespace WeDevBr\Celcoin\Clients;

use Illuminate\Support\Facades\Validator;
use WeDevBr\Celcoin\Common\CelcoinBaseApi;
use WeDevBr\Celcoin\Enums\EntityWebhookBAASEnum;
use WeDevBr\Celcoin\Rules\BAAS\RegisterWebhooks as BAASRegisterWebhooks;
use WeDevBr\Celcoin\Types\BAAS\RegisterWebhooks;

/**
 * Class CelcoinWebhooks
 * API de BaaS possui o modulo de Gerenciamento de Webhook, com esses serviços você consegue administrar suas rotas de Webhook sem precisar acionar o time da Celcoin
 * @package WeDevBr\Celcoin
 */
class CelcoinBAASWebhooks extends CelcoinBaseApi
{
    const REGISTER_ENDPOINT = '/baas-webhookmanager/v1/webhook/subscription';
    const LIST_ENDPOINT = '/baas-webhookmanager/v1/webhook/subscription';

    public function register(RegisterWebhooks $data)
    {
        $body = Validator::validate($data->toArray(), BAASRegisterWebhooks::rules());
        return $this->post(
            self::REGISTER_ENDPOINT,
            $body
        );
    }

    public function list(EntityWebhookBAASEnum $entity, bool $active)
    {
        return $this->get(self::LIST_ENDPOINT, [
            'Entity' => $entity->value,
            'Active' => $active ? 'true' : 'false'
        ]);
    }
}
