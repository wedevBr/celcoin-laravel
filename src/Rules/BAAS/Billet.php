<?php

namespace WeDevBr\Celcoin\Rules\BAAS;

use WeDevBr\Celcoin\Enums\ClientFinalityEnum;

class Billet
{
    public static function rules(): array
    {
        return [
            'externalId' => ['required'],
            'merchantCategoryCode' => ['sometimes', 'required'],
            'expirationAfterPayment' => ['boolean'],
            'duedate' => ['required', 'date'],
            'amount' => ['required', 'decimal:0,2'],
            'key' => ['required'],
            'debtor' => ['required', 'array'],
            'debtor.name' => ['required'],
            'debtor.document' => ['required', 'numeric'],
            'debtor.postalCode' => ['required', 'numeric'],
            'debtor.publicArea' => ['required'],
            'debtor.number' => ['required', 'numeric'],
            'debtor.complement' => ['nullable'],
            'debtor.neighborhood' => ['required'],
            'debtor.city' => ['required'],
            'debtor.state' => ['required'],
            'receiver.document' => ['required','numeric'],
            'receiver.account' => ['required','numeric'],
            'instructions' => ['sometimes', 'array', 'nullable'],
            'instructions.discount' => ['required_with:instructions','array'],
            'instructions.discount.amount' => ['required_with:discount','decimal:0,2'],
            'instructions.discount.modality' => ['required_with:discount'],
            'instructions.discount.limitDate' => ['required_with:discount', 'date'],
            'instructions.fine' => ['nullable','decimal:0,2'],
            'instructions.interest' => ['nullable','decimal:0,2'],
            'split' => ['sometimes', 'array'],
            'split.*.account' => ['nullable', 'numeric'],
            'split.*.document' => ['nullable', 'numeric'],
            'split.*.percent' => ['nullable', 'decimal:0,2'],
            'split.*.amount' => ['nullable', 'decimal:0,2'],
            'split.*.aggregatePayment' => ['nullable', 'boolean'],
        ];
    }
}
