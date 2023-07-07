<?php

namespace WeDevBr\Celcoin\Enums;

enum ReasonRefundPixEnum: string
{
    case RETURNED_DUE_TO_BANKING_ERROR = 'BE08';
    case RETURNED_DUE_TO_FRAUD_SUSPICION = 'FR01';
    case RETURNED_AT_END_CUSTOMER_REQUEST = 'MD06';
    case RETURNED_CASH_AMOUNT_DUE_TO_PIX_WITHDRAWAL_OR_CHANGE_ERROR = 'SL02';
}
