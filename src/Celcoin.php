<?php

namespace WeDevBr\Celcoin;

use WeDevBr\Celcoin\Clients\CelcoinAssistant;
use WeDevBr\Celcoin\Clients\CelcoinBAAS;
use WeDevBr\Celcoin\Clients\CelcoinBAASBillPayment;
use WeDevBr\Celcoin\Clients\CelcoinBAASBillet;
use WeDevBr\Celcoin\Clients\CelcoinBAASPIX;
use WeDevBr\Celcoin\Clients\CelcoinBAASTED;
use WeDevBr\Celcoin\Clients\CelcoinBAASWebhooks;
use WeDevBr\Celcoin\Clients\CelcoinBankTransfer;
use WeDevBr\Celcoin\Clients\CelcoinBillPayment;
use WeDevBr\Celcoin\Clients\CelcoinDDAInvoice;
use WeDevBr\Celcoin\Clients\CelcoinDDAUser;
use WeDevBr\Celcoin\Clients\CelcoinDDAWebhooks;
use WeDevBr\Celcoin\Clients\CelcoinElectronicTransactions;
use WeDevBr\Celcoin\Clients\CelcoinKyc;
use WeDevBr\Celcoin\Clients\CelcoinPIXCOB;
use WeDevBr\Celcoin\Clients\CelcoinPIXCOBV;
use WeDevBr\Celcoin\Clients\CelcoinPIXDICT;
use WeDevBr\Celcoin\Clients\CelcoinPIXDynamic;
use WeDevBr\Celcoin\Clients\CelcoinPIXParticipants;
use WeDevBr\Celcoin\Clients\CelcoinPIXPayment;
use WeDevBr\Celcoin\Clients\CelcoinPIXQR;
use WeDevBr\Celcoin\Clients\CelcoinPIXReceivement;
use WeDevBr\Celcoin\Clients\CelcoinPIXReverse;
use WeDevBr\Celcoin\Clients\CelcoinPixStaticPayment;
use WeDevBr\Celcoin\Clients\CelcoinPixWebhooks;
use WeDevBr\Celcoin\Clients\CelcoinReport;
use WeDevBr\Celcoin\Clients\CelcoinTopups;

/**
 * Class Celcoin
 *
 * @package WeDevBr\Celcoin
 */
class Celcoin
{

    /**
     * @return CelcoinAssistant
     */
    public static function clientAssistant(): CelcoinAssistant
    {
        return new CelcoinAssistant();
    }

    /**
     * @return CelcoinBankTransfer
     */
    public static function clientBankTransfer(): CelcoinBankTransfer
    {
        return new CelcoinBankTransfer();
    }

    /**
     * @return CelcoinBillPayment
     */
    public static function clientBillPayment(): CelcoinBillPayment
    {
        return new CelcoinBillPayment();
    }

    /**
     * @return CelcoinDDAInvoice
     */
    public static function clientDDAInvoice(): CelcoinDDAInvoice
    {
        return new CelcoinDDAInvoice();
    }

    /**
     * @return CelcoinDDAUser
     */
    public static function clientDDAUser(): CelcoinDDAUser
    {
        return new CelcoinDDAUser();
    }

    /**
     * @return CelcoinDDAWebhooks
     */
    public static function clientDDAWebhooks(): CelcoinDDAWebhooks
    {
        return new CelcoinDDAWebhooks();
    }

    /**
     * @return CelcoinReport
     */
    public static function clientCelcoinReport(): CelcoinReport
    {
        return new CelcoinReport();
    }

    /**
     * @return CelcoinElectronicTransactions
     */
    public static function clientElectronicTransactions(): CelcoinElectronicTransactions
    {
        return new CelcoinElectronicTransactions();
    }

    /**
     * @return CelcoinTopups
     */
    public static function clientTopups(): CelcoinTopups
    {
        return new CelcoinTopups();
    }

    /**
     * @return CelcoinPIXQR
     */
    public static function clientPIXQR(): CelcoinPIXQR
    {
        return new CelcoinPIXQR();
    }

    /**
     * @return CelcoinPIXParticipants
     */
    public static function clientPIXParticipants(): CelcoinPIXParticipants
    {
        return new CelcoinPIXParticipants();
    }

    /**
     * @return CelcoinPIXDICT
     */
    public static function clientPIXDICT(): CelcoinPIXDICT
    {
        return new CelcoinPIXDICT();
    }

    /**
     * @return CelcoinPixStaticPayment
     */
    public static function clientPixStaticPayment(): CelcoinPixStaticPayment
    {
        return new CelcoinPixStaticPayment();
    }

    /**
     * @return CelcoinPIXCOBV
     */
    public static function clientPixCOBV(): CelcoinPIXCOBV
    {
        return new CelcoinPIXCOBV();
    }

    /**
     * @return CelcoinPIXCOB
     */
    public static function clientPixCOB(): CelcoinPIXCOB
    {
        return new CelcoinPIXCOB();
    }

    /**
     * @return CelcoinBAAS
     */
    public static function clientBAAS(): CelcoinBAAS
    {
        return new CelcoinBAAS();
    }

    /**
     * @return CelcoinBAASPIX
     */
    public static function clientBAASPIX(): CelcoinBAASPIX
    {
        return new CelcoinBAASPIX();
    }

    /**
     * @return CelcoinBAASTED
     */
    public static function clientBAASTED(): CelcoinBAASTED
    {
        return new CelcoinBAASTED();
    }

    /**
     * @return CelcoinBAASWebhooks
     */
    public static function clientBAASWebhooks(): CelcoinBAASWebhooks
    {
        return new CelcoinBAASWebhooks();
    }

    /**
     * @return CelcoinPIXDynamic
     */
    public static function clientPIXDynamic(): CelcoinPIXDynamic
    {
        return new CelcoinPIXDynamic();
    }

    /**
     * @return CelcoinPIXPayment
     */
    public static function clientPIXPayment(): CelcoinPIXPayment
    {
        return new CelcoinPIXPayment();
    }

    /**
     * @return CelcoinPIXReceivement
     */
    public static function clientPIXReceivement(): CelcoinPIXReceivement
    {
        return new CelcoinPIXReceivement();
    }

    /**
     * @return CelcoinPIXReverse
     */
    public static function clientPIXReverse(): CelcoinPIXReverse
    {
        return new CelcoinPIXReverse();
    }

    /**
     * @return CelcoinPixWebhooks
     */
    public static function clientPixWebhooks(): CelcoinPixWebhooks
    {
        return new CelcoinPixWebhooks();
    }

    /**
     * @return CelcoinKyc
     */
    public static function clientKyc(): CelcoinKyc
    {
        return new CelcoinKyc();
    }

    /**
     * @return CelcoinBAASBillPayment
     */
    public static function clientBAASBillPayment(): CelcoinBAASBillPayment
    {
        return new CelcoinBAASBillPayment();
    }

    /**
     * @return CelcoinBAASBillet
     */
    public static function clientBAASBillet(): CelcoinBAASBillet
    {
        return new CelcoinBAASBillet();
    }
}
