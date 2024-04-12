<?php

namespace WeDevBr\Celcoin\Rules\BankTransfer;

use Illuminate\Validation\Rule;
use WeDevBr\Celcoin\Enums\AccountTypeEnum;

class Create
{
    public static function rules()
    {
        return [
            'document' => ['required', 'string'],
            'externalTerminal' => ['required', 'string'],
            'externalNSU' => ['nullable', 'integer'],
            'accountCode' => ['required', 'string'],
            'digitCode' => ['nullable', 'string'],
            'branchCode' => ['required', 'string'],
            'institutionCode' => ['nullable', 'integer'],
            'name' => ['nullable', 'string'],
            'value' => ['required', 'decimal:0,2'],
            'bankAccountType' => ['nullable', Rule::in(array_column(AccountTypeEnum::cases(), 'value'))],
            'institutionIspb' => ['nullable', 'string'],
        ];
    }
}
