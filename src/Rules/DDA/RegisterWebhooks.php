<?php

namespace WeDevBr\Celcoin\Rules\DDA;

class RegisterWebhooks
{
    public static function rules()
    {
        return [
            "typeEventWebhook" => ['required', 'in:Subscription,Deletion,Invoice'],
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
