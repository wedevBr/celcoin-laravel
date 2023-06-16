<?php

namespace WeDevBr\Celcoin\Rules\Topups;

class ProvidersValues
{
    public static function rules()
    {
        return [
            "stateCode" => ['nullable', 'numeric'],
            "providerId" => ['nullable', 'string'],
        ];
    }
}
