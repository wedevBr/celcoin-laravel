<?php

namespace WeDevBr\Celcoin\Rules\PIX;

class PaymentInitRules
{
    /**
     * @return array[]
     */
    public static function rules(): array
    {
        return [
            'amount' => [
                'required',
                'decimal:2,2'
            ],
            'vlcpAmount' => [
                'decimal:2,2',
                'required_if:transactionType,CHANGE'
            ],
            'vldnAmount' => [
                'decimal:2,2',
                'required_if:transactionType,WITHDRAWAL',
                'required_if:transactionType,CHANGE'
            ],
            'withdrawalServiceProvider' => [
                'string',
                'required_if:transactionType,WITHDRAWAL'
            ],
            'withdrawalAgentMode' => [
                'in:AGTEC,AGTOT,AGPSS',
                'required_if:transactionType,CHANGE',
                'required_if:transactionType,WITHDRAWAL',
            ],
            'clientCode' => ['required', 'string'],
            'transactionIdentification' => [
                'sometimes',
                'string',
            ],
            'endToEndId' => ['sometimes', 'string'],
            'debitParty' => ['sometimes', 'array'],
            'debitParty.Account' => ['sometimes', 'string'],
            'debitParty.Bank' => ['sometimes', 'string'],
            'debitParty.Branch' => ['sometimes', 'string'],
            'debitParty.PersonType' => ['sometimes', 'string'],
            'debitParty.TaxId' => ['sometimes', 'string'],
            'debitParty.AccountType' => ['sometimes', 'string'],
            'debitParty.Name' => ['sometimes', 'string'],
            'creditParty' => ['sometimes', 'array'],
            'creditParty.Account' => ['sometimes', 'string'],
            'creditParty.Bank' => ['sometimes', 'string'],
            'creditParty.Branch' => ['sometimes', 'string'],
            'creditParty.PersonType' => ['sometimes', 'string'],
            'creditParty.TaxId' => ['sometimes', 'string'],
            'creditParty.AccountType' => ['sometimes', 'string'],
            'creditParty.Name' => ['sometimes', 'string'],
            'creditParty.Key' => ['sometimes', 'string'],
            'initiationType' => ['required', 'in:MANUAL,DICT,STATIC_QRCODE,DYNAMIC_QRCODE,PAYMENT_INITIATOR'],
            'taxIdPaymentInitiator' => ['sometimes', 'string'],
            'paymentType' => ['sometimes', 'in:IMMEDIATE,FRAUD,SCHEDULED'],
            'urgency' => ['sometimes', 'in:NORMAL,HIGH'],
            'transactionType' => ['sometimes', 'in:TRANSFER,CHANGE,WITHDRAWAL'],
        ];
    }
}
