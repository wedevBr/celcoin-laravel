<?php

namespace WeDevBr\Celcoin\Clients;

use Illuminate\Http\Client\RequestException;
use Illuminate\Support\Facades\Validator;
use WeDevBr\Celcoin\Common\CelcoinBaseApi;
use WeDevBr\Celcoin\Enums\WebhookEventEnum;
use WeDevBr\Celcoin\Rules\PIX as Rules;
use WeDevBr\Celcoin\Types\PIX as Types;

class CelcoinPixWebhooks extends CelcoinBaseApi
{
    const PIX_WEBHOOK_GET_LIST_ENDPOINT = '/webhook-manager-webservice/v1/webhook/%s';
    const PIX_REACTIVATE_RESEND_PENDING_ENDPOINT = '/webhook-manager-webservice/v1/webhook/resend/%s';

    /**
     * @throws RequestException
     */
    final public function getList(
        WebhookEventEnum        $webhookEvent,
        Types\PixWebhookGetList $webhookGetList
    ): ?array
    {
        $params = Validator::validate($webhookGetList->toArray(), Rules\WebhookGetList::rules());

        $url = sprintf(self::PIX_WEBHOOK_GET_LIST_ENDPOINT, $webhookEvent->value);

        if ($params) {
            $url .= '?' . http_build_query($params);
        }

        return $this->get(
            $url
        );
    }


    /**
     * @throws RequestException
     */
    final public function reactivateAndResendAllPendingMessages(
        WebhookEventEnum                               $webhookEvent,
        Types\PixReactivateAndResendAllPendingMessages $allPendingMessages
    ): ?array
    {
        $params = Validator::validate(
            $allPendingMessages->toArray(),
            Rules\PixReactivateAndResendAllPendingMessages::rules()
        );

        $url = sprintf(self::PIX_REACTIVATE_RESEND_PENDING_ENDPOINT, $webhookEvent->value);

        if ($params) {
            $url .= '?' . http_build_query($params);
        }

        return $this->post(
            $url
        );

    }

}
