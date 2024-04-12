<?php

namespace WeDevBr\Celcoin\Rules\PIX;

use Illuminate\Validation\Rule;
use WeDevBr\Celcoin\Enums\ClaimAnswerReasonEnum;

class ClaimAnswer
{
    public static function rules(): array
    {
        return [
            'id' => ['required', 'uuid'],
            'reason' => ['required', Rule::enum(ClaimAnswerReasonEnum::class)],
        ];
    }
}
