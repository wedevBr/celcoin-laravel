<?php

namespace WeDevBr\Celcoin\Rules\BillPayments;

use Illuminate\Validation\Rule;
use WeDevBr\Celcoin\Enums\BarCodeTypeEnum;
use WeDevBr\Celcoin\Enums\MethodPaymentCodeEnum;

class Create
{

    public static function rules()
    {
        return [
            "externalNSU" => ['nullable', 'integer'],
            "externalTerminal" => ['nullable', 'string'],
            "cpfcnpj" => ['required', 'string'],
            "billData" => ['required', 'array'],
            "billData.value" => ['nullable', 'decimal:0,2'],
            "billData.originalValue" => ['required', 'decimal:0,2'],
            "billData.valueWithDiscount" => ['required', 'decimal:0,2'],
            "billData.valueWithAdditional" => ['required', 'decimal:0,2'],
            "infoBearer" => ['nullable', 'array'],
            "infoBearer.nameBearer" => ['nullable', 'string'],
            "infoBearer.documentBearer" => ['nullable', 'string'],
            "infoBearer.methodPaymentCode" => ['nullable', Rule::in(array_column(MethodPaymentCodeEnum::cases(), 'value'))],
            "barCode" => ['required', 'array'],
            "barCode.type" => ['required', Rule::in(array_column(BarCodeTypeEnum::cases(), 'value'))],
            "barCode.digitable" => ['nullable', 'string'],
            "barCode.barCode" => ['nullable', 'string'],
            "dueDate" => ['nullable', 'date_format:Y-m-d'],
            "transactionIdAuthorize" => ['nullable', 'integer']
        ];
    }
}
