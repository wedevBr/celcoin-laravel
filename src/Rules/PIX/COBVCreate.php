<?php

namespace WeDevBr\Celcoin\Rules\PIX;

class COBVCreate
{
    /**
     * @return array[]
     */
    public static function rules(): array
    {
        return [
            'clientRequestId' => ['required'],
            'expirationAfterPayment' => ['required'],
            'duedate' => ['required'],
            'debtor' => ['required', 'array'],
            'debtor.name' => ['required'],
            'debtor.cpf' => ['sometimes', 'required_without:debtor.cnpj'],
            'debtor.cnpj' => ['sometimes', 'required_without:debtor.cpf'],
            'debtor.city' => ['required'],
            'debtor.publicArea' => ['required'],
            'debtor.state' => ['required'],
            'debtor.postalCode' => ['required'],
            'debtor.email' => ['required', 'email'],
            'receiver' => ['required', 'array'],
            'receiver.name' => ['required'],
            'receiver.cpf' => ['sometimes', 'required_without:debtor.cnpj'],
            'receiver.cnpj' => ['sometimes', 'required_without:debtor.cpf'],
            'receiver.postalCode' => ['required'],
            'receiver.city' => ['required'],
            'receiver.publicArea' => ['required'],
            'receiver.state' => ['required'],
            'receiver.fantasyName' => ['required_with:cnpj'],
            'amount' => ['required', 'decimal:2'],
            'amountDicount' => ['sometimes', 'required', 'array'],
            'amountAbatement' => ['sometimes', 'required', 'array'],
            'amountFine' => ['sometimes', 'required', 'array'],
            'amountInterest' => ['sometimes', 'required', 'array'],
            'additionalInformation' => ['sometimes', 'required', 'array'],
            'payerQuestion' => ['sometimes', 'required'],
            'key' => ['required'],
        ];
    }
}
