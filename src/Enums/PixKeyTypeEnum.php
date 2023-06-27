<?php

namespace WeDevBr\Celcoin\Enums;

enum PixKeyTypeEnum: string
{
    case CPF = 'CPF';
    case CNPJ = 'CNPJ';
    case EMAIL = 'EMAIL';
    case PHONE = 'PHONE';
    case EVP = 'EVP';
}
