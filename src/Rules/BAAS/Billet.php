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
            'amount' => ['required', 'numeric:0,2'],
            'key' => ['sometimes', 'nullable'],
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
            'instructions' => ['sometimes', 'array'],
            'instructions.discounts' => ['required_with:instructions','array'],
            'instructions.discounts.*.amount' => ['nullable','numeric:0,2'],
            'instructions.discounts.*.modality' => ['nullable'],
            'instructions.discounts.*.limitDate' => ['nullable', 'date'],
            'instructions.fine' => ['nullable','numeric:0,2'],
            'instructions.interest' => ['nullable','numeric:0,2'],
            'split' => ['sometimes', 'array'],
            'split.*.account' => ['nullable', 'numeric'],
            'split.*.document' => ['nullable', 'numeric'],
            'split.*.percent' => ['nullable', 'numeric'],
            'split.*.amount' => ['nullable', 'numeric'],
            'split.*.aggregatePayment' => ['nullable', 'boolean'],
        ];
    }
}
