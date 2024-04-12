<?php

namespace WeDevBr\Celcoin\Rules\BillPayments;

use Illuminate\Validation\Rule;
use WeDevBr\Celcoin\Enums\BarCodeTypeEnum;

class Authorize
{
    public static function rules()
    {
        return [
            'externalTerminal' => ['nullable', 'string'],
            'externalNSU' => ['nullable', 'numeric'],
            'barCode' => ['required', 'array'],
            'barCode.type' => ['required', Rule::in(array_column(BarCodeTypeEnum::cases(), 'value'))],
            'barCode.digitable' => ['required_without:barCode.barCode', 'string'],
            'barCode.barCode' => ['required_without:barCode.digitable', 'string'],
        ];
    }
}
