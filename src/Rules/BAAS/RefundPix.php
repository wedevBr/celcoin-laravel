<?php

namespace WeDevBr\Celcoin\Rules\BAAS;

use Illuminate\Validation\Rule;
use WeDevBr\Celcoin\Enums\ReasonRefundPixEnum;

class RefundPix
{
    public static function rules()
    {
        return [
            'id' => ['nullable', 'string'],
            'endToEndId' => ['nullable', 'string'],
            'clientCode' => ['required', 'string'],
            'amount' => ['required', 'regex:/\d{1,10}\.\d{2}/'],
            'reason' => ['required', Rule::in(array_column(ReasonRefundPixEnum::cases(), 'value'))],
            'reversalDescription' => ['nullable', 'string'],
        ];
    }
}
