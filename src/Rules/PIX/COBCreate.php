<?php

namespace WeDevBr\Celcoin\Rules\PIX;

class COBCreate
{
    /**
     * @return array[]
     */
    public static function rules(): array
    {
        return [
            'clientRequestId' => ['required'],
            'payerQuestion' => ['sometimes', 'required'],
            'key' => ['required'],
            'locationId' => ['required', 'integer'],
            'debtor' => ['required', 'array'],
            'debtor.name' => ['required', 'string'],
            'debtor.cpf' => ['required_without:debtor.cnpj'],
            'debtor.cnpj' => ['required_without:debtor.cpf'],
            'amount' => ['array', 'required'],
            'amount.original' => ['required', 'decimal:2'],
            'amount.changeType' => ['sometimes', 'boolean'],
            'calendar' => ['required', 'array'],
            'calendar.expiration' => ['required', 'integer'],
            'additionalInformation' => ['sometimes', 'array'],
            'additionalInformation.*.value' => ['required', 'sometimes', 'string'],
            'additionalInformation.*.key' => ['required', 'sometimes', 'string'],
        ];
    }
}
