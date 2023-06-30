<?php

namespace WeDevBr\Celcoin\Enums;

enum MethodPaymentCodeEnum: string
{
    case CASH = '1';
    case ACCOUNT_DEBIT = '2';
    case CREDIT_CARD = '3';
    case CHECK = '4';
}
