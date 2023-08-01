<?php

namespace WeDevBr\Celcoin\Enums;

enum InitiationTypeEnum: string
{
    case PAYMENT_MANUAL = 'MANUAL';
    case PAYMENT_DICT = 'DICT';
    case PAYMENT_STATIC_BRCODE = 'STATIC_QRCODE';
    case PAYMENT_DYNAMIC_BRCODE = 'DYNAMIC_QRCODE';
}
