<?php

namespace WeDevBr\Celcoin\Rules\Topups;

use Illuminate\Validation\Rule;
use WeDevBr\Celcoin\Enums\TopupProvidersCategoryEnum;
use WeDevBr\Celcoin\Enums\TopupProvidersTypeEnum;

class Providers
{
    public static function rules()
    {
        return [
            'stateCode' => ['required', 'integer'],
            'type' => ['required', Rule::in(array_column(TopupProvidersTypeEnum::cases(), 'value'))],
            'category' => ['required', Rule::in(array_column(TopupProvidersCategoryEnum::cases(), 'value'))],
        ];
    }
}
