<?php

namespace WeDevBr\Celcoin\Facades;

use Illuminate\Support\Facades\Facade;

/**
 * @uses Celcoin::clientAssistant
 * @uses Celcoin::clientBankTransfer
 * @uses Celcoin::clientBillPayment
 * @uses Celcoin::clientDDAInvoice
 * @uses Celcoin::clientDDAUser
 * @uses Celcoin::clientDDAWebhooks
 * @uses Celcoin::clientCelcoinReport
 * @uses Celcoin::clientElectronicTransactions
 * @uses Celcoin::clientTopups
 * @uses Celcoin::clientBAAS
 * @uses Celcoin::clientBAASBillet
 * @uses Celcoin::clientBAASTED
 * @uses Celcoin::clientBAASWebhooks
 * @uses Celcoin::clientBAASPIX
 * @uses Celcoin::clientPIXQR
 * @uses Celcoin::clientPIXParticipants
 * @uses Celcoin::clientPIXDICT
 * @uses Celcoin::clientPixStaticPayment
 * @uses Celcoin::clientPixCOBV
 * @uses Celcoin::clientPixCOB
 * @uses Celcoin::clientPIXDynamic
 * @uses Celcoin::clientPIXPayment
 * @uses Celcoin::clientPIXReceivement
 * @uses Celcoin::clientPIXReverse
 * @uses Celcoin::clientPixWebhooks
 * @uses Celcoin::clientKyc
 * @uses Celcoin::clientBAASWebhook
 * @uses Celcoin::clientInternationalTopup
 * @uses Celcoin::clientBAASBillPayment
 * @uses Celcoin::clientBAASBillet
 */
class CelcoinFacade extends Facade
{
    /**
     * Get the registered name of the component.
     */
    protected static function getFacadeAccessor(): string
    {
        return 'celcoin';
    }
}
