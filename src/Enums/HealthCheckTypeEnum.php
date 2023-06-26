<?php

namespace WeDevBr\Celcoin\Enums;

enum HealthCheckTypeEnum: string
{
    case ACCOUNT_DATA_QUERY = "CONSULTADADOSCONTA";
    case RECEIVE_BILL = "RECEBERCONTA";
    case RECHARGE = "RECARGA";
}
