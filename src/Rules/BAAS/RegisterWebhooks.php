<?php

namespace WeDevBr\Celcoin\Rules\BAAS;

use Illuminate\Validation\Rule;
use UnitEnum;
use WeDevBr\Celcoin\Enums\EntityWebhookBAASEnum;

class RegisterWebhooks
{
    public static function rules()
    {
        return [
            "entity" => ['required', Rule::in(array_map(fn (EntityWebhookBAASEnum $enum) => $enum->value, EntityWebhookBAASEnum::cases()))],
            "webhookUrl" => ['required', 'string'],
            "auth" => ['nullable', 'array'],
            "auth.login" => ['nullable', 'string'],
            "auth.pwd" => ['nullable', 'string'],
            "auth.type" => ['nullable', 'string'],
        ];
    }
}
