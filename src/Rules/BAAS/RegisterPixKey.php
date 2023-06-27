<?php

namespace WeDevBr\Celcoin\Rules\BAAS;

use Illuminate\Validation\Rule;
use WeDevBr\Celcoin\Enums\PixKeyTypeEnum;
use WeDevBr\Celcoin\Types\Data;

class RegisterPixKey extends Data
{
    public static function rules()
    {
        return [
            "account" => ['required', 'string'],
            "keyType" => ['required', Rule::in([PixKeyTypeEnum::EVP->value])],
            "key" => ['required_unless:keyType,EVP', 'string'],
        ];
    }
}
