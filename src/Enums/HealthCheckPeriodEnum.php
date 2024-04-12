<?php

namespace WeDevBr\Celcoin\Enums;

enum HealthCheckPeriodEnum: string
{
    case LAST_10_MINUTE = '0';
    case LAST_HOUR = '1';
    case LAST_2_HOURS = '2';
    case LAST_24_HOURS = '3';
}
