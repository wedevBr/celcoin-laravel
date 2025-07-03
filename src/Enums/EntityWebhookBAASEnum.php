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
    case VEHICLE_DEBTS_RECEIPT = 'vehicledebts-receipt';
    case VEHICLE_DEBTS_CONSULT = 'vehicledebts-consult';
    case VEHICLE_DEBTS = 'vehicledebts';
    case TOPUP = 'topup';
    case SLC_PAYMENT_IN = 'slc-payment-in';
    case PIX_REVERSAL_OUT_GALAX = 'pix-reversal-out-galax';
    case PIX_PAYMENT_IN_GALAX = 'pix-payment-in-galax';
    case PIX_DICT_CLAIM_WAITING = 'pix-dict-claim-waiting';
    case PIX_DICT_CLAIM_OPEN = 'pix-dict-claim-open';
    case PIX_DICT_CLAIM_CONFIRMED = 'pix-dict-claim-confirmed';
    case PIX_DICT_CLAIM_COMPLETED = 'pix-dict-claim-completed';
    case PIX_DICT_CLAIM_CANCELLED = 'pix-dict-claim-cancelled';
    case ONBOARDING_PROPOSAL = 'onboarding-proposal';
    case ONBOARDING_FILE = 'onboarding-file';
    case ONBOARDING_DOCUMENTSCOPY = 'onboarding-documentscopy';
    case ONBOARDING_BACKGROUNDCHECK = 'onboarding-backgroundcheck';
    case LIMIT = 'limit';
    case KYC = 'kyc';
    case JUDICIAL_MOVEMENT_OUT = 'judicial-movement-out';
    case JUDICIAL_MOVEMENT_IN = 'judicial-movement-in';
    case INTERNAL_TRANSFER_IN = 'internal-transfer-in';
    case INTERNAL_TRANSFER_OUT = 'internal-transfer-out';
    case CHARGE_IN = 'charge-in';
    case CHARGE_CREATE = 'charge-create';
    case CHARGE_CANCELED = 'charge-canceled';
    case BILLPAYMENT = 'billpayment';
    case BILLPAYMENT_OCCURRENCE = 'billpayment-occurrence';
    case ACCOUNT_MIGRATION = 'account-migration';
}
