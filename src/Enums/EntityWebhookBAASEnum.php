<?php

namespace WeDevBr\Celcoin\Enums;

enum EntityWebhookBAASEnum: string
{
    case ONBOARDING_CREATE = 'onboarding-create';
    case PIX_PAYMENT_OUT = 'pix-payment-out';
    case PIX_PAYMENT_IN = 'pix-payment-in';
    case PIX_REVERSAL_IN = 'pix-reversal-in';
    case PIX_REVERSAL_OUT = 'pix-reversal-out';
    case SPB_TRANSFER_OUT_TED = 'spb-transfer-out';
    case SPB_TRANSFER_IN_TED = 'spb-transfer-in';
    case SPB_REVERSAL_OUT_TED = 'spb-reversal-out';
    case SPB_REVERSAL_IN_TED = 'spb-reversal-in';
}
