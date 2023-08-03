<?php

namespace WeDevBr\Celcoin\Enums;

enum WebhookEventEnum: string
{
    case CONFIRMED = 'CONFIRMED';
    case ERROR = 'ERROR';
    case REVERTED = 'REVERTED';
    case PAID = 'PAID';
    case PAYMENT_REVERTED = 'PAYMENT_REVERTED';
}
