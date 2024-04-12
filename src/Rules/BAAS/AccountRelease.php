<?php

namespace WeDevBr\Celcoin\Rules\BAAS;

use Illuminate\Validation\Rule;
use WeDevBr\Celcoin\Enums\TypeReleaseEnum;

class AccountRelease
{
    public static function rules()
    {
        return [
            'clientCode' => ['nullable', 'string'],
            'amount' => ['nullable', 'decimal:0,2'],
            'type' => ['nullable', Rule::in(array_column(TypeReleaseEnum::cases(), 'value'))],
            'description' => ['nullable', 'string', 'max:250'],
        ];
    }
}
