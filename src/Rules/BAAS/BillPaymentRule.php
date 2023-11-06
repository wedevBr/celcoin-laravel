<?php

namespace WeDevBr\Celcoin\Rules\BAAS;

use Illuminate\Validation\Rule;
use WeDevBr\Celcoin\Enums\BarCodeTypeEnum;

class BillPaymentRule
{
    public static function rules(): array
    {
        return [
            'clientRequestId' => ['required', 'string', 'max:20'],
            'amount' => ['required', 'decimal:0,2', 'min: 0.01'],
            'account' => ['required', 'string', 'numeric'],
            'transactionIdAuthorize' => ['required', 'integer'],
            'tags' => ['sometimes', 'nullable', 'array'],
            'tags.*.key' => ['required_if:tags', 'string'],
            'tags.*.value' => ['required_if:tags', 'string'],
            "barCodeInfo" => ['required', 'array'],
            "barCodeInfo.type" => ['required', Rule::in(array_column(BarCodeTypeEnum::cases(), 'value'))],
            "barCodeInfo.digitable" => ['nullable', 'string'],
            "barCodeInfo.barCode" => ['nullable', 'string'],
        ];
    }
}