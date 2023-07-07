<?php

namespace WeDevBr\Celcoin\Enums;

enum ClientFinalityEnum: string
{
    case TAXES_AND_FEES = '1';
    case DIVIDEND_PAYMENTS = '3';
    case SALARY_PAYMENT = '4';
    case SUPPLIER_PAYMENT = '5';
    case RENT_AND_CONDO_FEES = '7';
    case SCHOOL_TUITION_PAYMENT = '9';
    case ACCOUNT_CREDIT = '10';
    case JUDICIAL_DEPOSIT = '100';
    case SAME_OWNER_TRANSFER = '110';
    case OTHERS = '99999';
}
