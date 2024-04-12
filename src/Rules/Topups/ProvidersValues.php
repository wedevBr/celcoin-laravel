<?php

namespace WeDevBr\Celcoin\Rules\Topups;

class ProvidersValues
{
    public static function rules()
    {
        return [
            'stateCode' => ['required', 'integer'],
            'providerId' => ['required', 'string'],
        ];
    }
}
