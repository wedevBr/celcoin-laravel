<?php

namespace WeDevBr\Celcoin\Rules\PIX;

class COBVUpdate
{
    final public static function rules(): array
    {
        return [
            'clientRequestId' => ['sometimes'],
            'expirationAfterPayment' => ['sometimes'],
            'duedate' => ['sometimes'],
            'debtor' => ['sometimes', 'array'],
            'debtor.name' => ['sometimes'],
            'debtor.cpf' => ['sometimes', 'required_without:debtor.cnpj'],
            'debtor.cnpj' => ['sometimes', 'required_without:debtor.cpf'],
            'debtor.city' => ['sometimes'],
            'debtor.publicArea' => ['sometimes'],
            'debtor.state' => ['sometimes'],
            'debtor.postalCode' => ['sometimes'],
            'debtor.email' => ['sometimes', 'email'],
            'receiver' => ['sometimes', 'array'],
            'receiver.name' => ['sometimes'],
            'receiver.cpf' => ['sometimes', 'required_without:debtor.cnpj'],
            'receiver.cnpj' => ['sometimes', 'required_without:debtor.cpf'],
            'receiver.postalCode' => ['sometimes'],
            'receiver.city' => ['sometimes'],
            'receiver.publicArea' => ['sometimes'],
            'receiver.state' => ['sometimes'],
            'receiver.fantasyName' => ['sometimes', 'required_with:cnpj'],
            'locationId' => ['sometimes', 'int'],
            'amount' => ['sometimes', 'decimal:2'],
            'amountDicount' => ['sometimes', 'array'],
            'amountAbatement' => ['sometimes', 'array'],
            'amountFine' => ['sometimes', 'array'],
            'amountInterest' => ['sometimes', 'array'],
            'additionalInformation' => ['sometimes', 'array'],
            'payerQuestion' => ['sometimes'],
            'key' => ['sometimes'],
        ];
    }
}
