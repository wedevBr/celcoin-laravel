<?php

namespace WeDevBr\Celcoin\Enums;

enum KycDocumentEnum: string
{
    case RG = 'RG';
    case CNH = 'CNH';
    case RNE = 'RNE';
    case CARTAO_CNPJ = 'CARTAO_CNPJ';
    case CONTRATO_SOCIAL = 'CONTRATO_SOCIAL';
    case BALANCO = 'BALANCO';
    case FATURAMENTO = 'FATURAMENTO';
    case KYC_EXTERNO = 'KYC_EXTERNO';
}
