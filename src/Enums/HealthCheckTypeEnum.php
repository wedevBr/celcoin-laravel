<?php

namespace WeDevBr\Celcoin\Enums;

enum HealthCheckTypeEnum: string
{
    case CONSULTA_DADOS_CONTA = "CONSULTADADOSCONTA";
    case RECEBER_CONTA = "RECEBERCONTA";
    case RECARGA = "RECARGA";
}
