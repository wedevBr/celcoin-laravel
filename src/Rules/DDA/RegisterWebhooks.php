<?php

namespace WeDevBr\Celcoin\Rules\DDA;

use Illuminate\Validation\Rule;
use WeDevBr\Celcoin\Enums\DDAWebhooksTypeEventEnum;

class RegisterWebhooks
{
    public static function rules()
    {
        return [
            "typeEventWebhook" => ['required', Rule::in(array_column(DDAWebhooksTypeEventEnum::cases(), 'value'))],
            "url" => ['required', 'string'],
            "basicAuthentication" => ['nullable', 'array'],
            "basicAuthentication.identification" => ['nullable', 'string'],
            "basicAuthentication.password" => ['nullable', 'string'],
            "oAuthTwo" => ['nullable', 'array'],
            "oAuthTwo.endpoint" => ['nullable', 'string'],
            "oAuthTwo.grantType" => ['nullable', 'string'],
            "oAuthTwo.clientId" => ['nullable', 'string'],
            "oAuthTwo.clientSecret" => ['nullable', 'string'],
            "oAuthTwo.scope" => ['nullable', 'string'],
            "oAuthTwo.state" => ['nullable', 'string'],
            "oAuthTwo.code" => ['nullable', 'string'],
            "oAuthTwo.refreshToken" => ['nullable', 'string'],
            "oAuthTwo.contentType" => ['nullable', 'string'],
        ];
    }
}
