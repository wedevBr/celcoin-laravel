<?php

namespace WeDevBr\Celcoin\Rules\PIX;

class COBUpdate
{
    /**
     * @return array[]
     */
    public static function rules(): array
    {
        return [
            'clientRequestId' => ['sometimes'],
            'payerQuestion' => ['sometimes'],
            'key' => ['sometimes'],
            'locationId' => ['sometimes', 'integer'],
            'debtor' => ['sometimes', 'array'],
            'debtor.name' => ['sometimes', 'string'],
            'debtor.cpf' => ['required_without:debtor.cnpj'],
            'debtor.cnpj' => ['required_without:debtor.cpf'],
            'amount' => ['sometimes', 'array'],
            'amount.original' => ['sometimes', 'decimal:2'],
            'amount.changeType' => ['sometimes', 'boolean'],
            'calendar' => ['sometimes', 'array'],
            'calendar.expiration' => ['sometimes', 'integer'],
            'additionalInformation' => ['sometimes', 'array'],
            'additionalInformation.*.value' => ['required_with:additionalInformation.*.key', 'string'],
            'additionalInformation.*.key' => ['required_with:additionalInformation.*.value', 'string'],
        ];
    }
}
