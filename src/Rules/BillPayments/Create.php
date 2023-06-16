<?php

namespace WeDevBr\Celcoin\Rules\BillPayments;

class Create
{

    public static function rules()
    {
        return [
            "externalNSU" => ['nullable', 'string'],
            "externalTerminal" => ['nullable', 'numeric'],
            "cpfcnpj" => ['required', 'string'],
            "billData" => ['required', 'array'],
            "billData.value" => 4000,
            "billData.originalValue" => 0,
            "billData.valueWithDiscount" => 0,
            "billData.valueWithAdditional" => 0,
            "infoBearer" => ['nullable', 'array'],
            "infoBearer.nameBearer" => ['nullable', 'string'],
            "infoBearer.documentBearer" => ['nullable', 'string'],
            "infoBearer.methodPaymentCode" => ['nullable', 'in:1,2,3,4'],
            "barCode" => ['required', 'array'],
            "barCode.type" => ['required', 'in:1,2'],
            "barCode.digitable" => ['nullable', 'string'],
            "barCode.barCode" => ['nullable', 'string'],
            "dueDate" => ['nullable', 'date'],
            "transactionIdAuthorize" => ['nullable', 'numeric']
        ];
    }
}
