<?php

namespace WeDevBr\Celcoin\Rules\BAAS;

use Illuminate\Validation\Rule;
use WeDevBr\Celcoin\Enums\EntityWebhookBAASEnum;

class EditWebhooks
{
    public static function rules()
    {
        return [
            'entity' => ['required', Rule::in(array_column(EntityWebhookBAASEnum::cases(), 'value'))],
            'webhookUrl' => ['required', 'string'],
            'auth' => ['nullable', 'array'],
            'auth.login' => ['nullable', 'string'],
            'auth.pwd' => ['nullable', 'string'],
            'auth.type' => ['nullable', 'string'],
            'active' => ['nullable', 'boolean'],
        ];
    }
}
