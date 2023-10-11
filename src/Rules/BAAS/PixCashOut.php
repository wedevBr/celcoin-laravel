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
    /**
     * @see https://developers.celcoin.com.br/docs/realizar-um-pix-cash-out-por-chaves-pix
     * @see https://developers.celcoin.com.br/docs/realizar-um-pix-cash-out
     * @param string $initiationTypeEnum
     * @return array
     */
    public static function rules(string $initiationTypeEnum): array
    {

        return match ($initiationTypeEnum) {
            InitiationTypeEnum::PAYMENT_MANUAL->value => self::manual(),
            InitiationTypeEnum::PAYMENT_DICT->value => self::dict(),
            InitiationTypeEnum::PAYMENT_STATIC_BRCODE->value => self::static(),
            InitiationTypeEnum::PAYMENT_DYNAMIC_BRCODE->value => self::dynamic(),
            default => self::defaultRules()
        };
    }

    private static function manual(): array
    {

        return array_merge(
            self::defaultRules(),
            [
                'transactionIdentification' => ['prohibited'],
                'endToEndId' => ['prohibited'],
                'creditParty.key' => ['prohibited'],
            ]
        );
    }

    private static function defaultRules(): array
    {
        return [
            'amount' => ['required', 'decimal:0,2'],
            'clientCode' => ['required', 'string'],
            'remittanceInformation' => ['nullable', 'string'],
            'initiationType' => ['required', Rule::in(array_column(InitiationTypeEnum::cases(), 'value'))],
            'paymentType' => ['required', Rule::in(array_column(PaymentTypeEnum::cases(), 'value'))],
            'urgency' => ['required', Rule::in(array_column(UrgencyEnum::cases(), 'value'))],
            'transactionType' => ['required', Rule::in(array_column(TransactionTypeEnum::cases(), 'value'))],
            'debitParty' => ['required', 'array'],
            'debitParty.account' => ['required', 'string'],
            //opcional ?
            'creditParty' => ['sometimes', 'array'],
            'creditParty.bank' => ['sometimes', 'string'],
            'creditParty.key' => ['sometimes', 'string'],
            'creditParty.account' => ['sometimes', 'string'],
            'creditParty.branch' => ['sometimes', 'string'],
            'creditParty.taxId' => ['sometimes', 'string'],
            'creditParty.name' => ['sometimes', 'string'],
            'creditParty.accountType' => [
                'sometimes',
                Rule::in(array_column(CreditPartyAccountTypeEnum::cases(), 'value')
                )
            ],
        ];
    }

    private static function dict(): array
    {
        return array_merge(
            self::defaultRules(),
            [
                'transactionIdentification' => ['prohibited'],
                'endToEndId' => ['required'],
                'creditParty' => ['required', 'array'],
                'creditParty.key' => ['required'],
            ]
        );
    }

    private static function static(): array
    {
        return array_merge(
            self::defaultRules(),
            [
                'transactionIdentification' => ['required', 'string', 'size:25'],
                'endToEndId' => ['required'],
                'creditParty.*' => ['required', 'array'],
                'creditParty.key' => ['required'],
            ]
        );
    }

    private static function dynamic(): array
    {
        return array_merge(
            self::defaultRules(),
            [
                'transactionIdentification' => ['required', 'string', 'min:26', 'min:35'],
                'endToEndId' => ['required'],
                'creditParty.*' => ['required', 'array'],
                'creditParty.key' => ['required'],
            ]
        );
    }
}
