<?php

namespace WeDevBr\Celcoin\Rules\BAAS;

use Illuminate\Validation\Rule;
use WeDevBr\Celcoin\Enums\CreditPartyAccountTypeEnum;
use WeDevBr\Celcoin\Enums\InitiationTypeEnum;
use WeDevBr\Celcoin\Enums\PaymentTypeEnum;
use WeDevBr\Celcoin\Enums\TransactionTypeEnum;
use WeDevBr\Celcoin\Enums\UrgencyEnum;

class PixCashOut
{
    public static function rules()
    {
        return [
            'amount' => ['required', 'regex:/\d{1,10}\.\d{2}/'],
            'clientCode' => ['required', 'string'],
            'transactionIdentification' => ['sometimes', 'required_unless:initiationType,' . InitiationTypeEnum::PAYMENT_DICT->value . ',' . InitiationTypeEnum::PAYMENT_MANUAL->value],
            'endToEndId' => ['sometimes', 'required_unless:initiationType,' . InitiationTypeEnum::PAYMENT_MANUAL->value],
            'initiationType' => ['required', Rule::in(array_column(InitiationTypeEnum::cases(), 'value'))],
            'paymentType' => ['required', Rule::in(array_column(PaymentTypeEnum::cases(), 'value'))],
            'urgency' => ['required', Rule::in(array_column(UrgencyEnum::cases(), 'value'))],
            'transactionType' => ['required', Rule::in(array_column(TransactionTypeEnum::cases(), 'value'))],
            'debitParty' => ['required', 'array'],
            'debitParty.account' => ['required', 'string'],
            'creditParty' => ['nullable', 'array'],
            'creditParty.bank' => ['required', 'string'],
            'creditParty.key' => ['nullable', 'string'],
            'creditParty.account' => ['required', 'string'],
            'creditParty.branch' => ['required', 'string'],
            'creditParty.taxId' => ['required', 'string'],
            'creditParty.name' => ['required', 'string'],
            'creditParty.accountType' => ['required', Rule::in(array_column(CreditPartyAccountTypeEnum::cases(), 'value'))],
            'remittanceInformation' => ['nullable', 'string'],
        ];
    }
}
