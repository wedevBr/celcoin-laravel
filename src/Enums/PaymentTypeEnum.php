<?php

namespace WeDevBr\Celcoin\Enums;

enum PaymentTypeEnum: string
{
    case IMMEDIATE = 'IMMEDIATE';
    case FRAUD = 'FRAUD';
    case SCHEDULED = 'SCHEDULED';
}
