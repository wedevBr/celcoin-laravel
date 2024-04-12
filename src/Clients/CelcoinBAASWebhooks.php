<?php

namespace WeDevBr\Celcoin\Clients;

use Illuminate\Support\Facades\Validator;
use WeDevBr\Celcoin\Common\CelcoinBaseApi;
use WeDevBr\Celcoin\Enums\EntityWebhookBAASEnum;
use WeDevBr\Celcoin\Rules\BAAS\EditWebhooks as BAASEditWebhooks;
use WeDevBr\Celcoin\Rules\BAAS\RegisterWebhooks as BAASRegisterWebhooks;
use WeDevBr\Celcoin\Types\BAAS\EditWebhooks;
use WeDevBr\Celcoin\Types\BAAS\RegisterWebhooks;

/**
 * Class CelcoinWebhooks
 * API de BaaS possui o modulo de Gerenciamento de Webhook, com esses serviços você consegue administrar suas rotas de Webhook sem precisar acionar o time da Celcoin
 */
class CelcoinBAASWebhooks extends CelcoinBaseApi
{
    public const REGISTER_ENDPOINT = '/baas-webhookmanager/v1/webhook/subscription';

    public const GET_ENDPOINT = '/baas-webhookmanager/v1/webhook/subscription';

    public const EDIT_ENDPOINT = 'baas-webhookmanager/v1/webhook/subscription/%s';

    public const REMOVE_ENDPOINT = 'baas-webhookmanager/v1/webhook/subscription/%s';

    public function register(RegisterWebhooks $data)
    {
        $body = Validator::validate($data->toArray(), BAASRegisterWebhooks::rules());

        return $this->post(
            self::REGISTER_ENDPOINT,
            $body
        );
    }

    public function getWebhook(EntityWebhookBAASEnum $entity, bool $active)
    {
        return $this->get(self::GET_ENDPOINT, [
            'Entity' => $entity->value,
            'Active' => $active ? 'true' : 'false',
        ]);
    }

    public function edit(EditWebhooks $data, EntityWebhookBAASEnum $entity)
    {
        $body = Validator::validate($data->toArray(), BAASEditWebhooks::rules());

        return $this->put(
            sprintf(self::EDIT_ENDPOINT, $entity->value),
            $body
        );
    }

    public function remove(EntityWebhookBAASEnum $entity)
    {
        return $this->delete(
            sprintf(self::REMOVE_ENDPOINT, $entity->value),
        );
    }
}
