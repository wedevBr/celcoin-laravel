<?php

namespace WeDevBr\Celcoin\Enums;

enum ClaimStatusEnum: string
{
    case OPEN = 'OPEN';
    case WAITING_RESOLUTION = 'WAITING_RESOLUTION';
    case CONFIRMED = 'CONFIRMED';
    case CANCELLED = 'CANCELLED';
    case COMPLETED = 'COMPLETED';
}
