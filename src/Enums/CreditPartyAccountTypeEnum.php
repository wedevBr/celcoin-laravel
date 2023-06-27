<?php

namespace WeDevBr\Celcoin\Enums;

enum CreditPartyAccountTypeEnum: string
{
    case NORMAL_OR_DIGITAL_ACCOUNTS = 'CACC';
    case PAYMENT_ACCOUNTS = 'TRAN';
    case SALARY_ACCOUNTS = 'SLRY';
    case SAVINGS_ACCOUNTS = 'SVGS';
}
