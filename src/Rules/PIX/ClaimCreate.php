<?php

namespace WeDevBr\Celcoin\Rules\PIX;

use Illuminate\Validation\Rule;
use WeDevBr\Celcoin\Enums\ClaimKeyTypeEnum;
use WeDevBr\Celcoin\Enums\ClaimTypeEnum;

class ClaimCreate
{
    public static function rules(): array
    {
        return [
            'key' => ['required'],
            'keyType' => ['required', Rule::enum(ClaimKeyTypeEnum::class)->when(
                ClaimTypeEnum::OWNERSHIP,
                fn ($rule) => $rule->only([ClaimKeyTypeEnum::PHONE, ClaimKeyTypeEnum::EMAIL]),
                fn ($rule) => $rule,
            )],
            'account' => ['required'],
            'claimType' => ['required', Rule::enum(ClaimTypeEnum::class)],
        ];
    }
}
