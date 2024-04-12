<?php

namespace WeDevBr\Celcoin;

use WeDevBr\Celcoin\Clients\CelcoinAssistant;
use WeDevBr\Celcoin\Clients\CelcoinBAAS;
use WeDevBr\Celcoin\Clients\CelcoinBAASBillet;
use WeDevBr\Celcoin\Clients\CelcoinBAASBillPayment;
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
 */
class Celcoin
{
    public static function clientAssistant(): CelcoinAssistant
    {
        return new CelcoinAssistant();
    }

    public static function clientBankTransfer(): CelcoinBankTransfer
    {
        return new CelcoinBankTransfer();
    }

    public static function clientBillPayment(): CelcoinBillPayment
    {
        return new CelcoinBillPayment();
    }

    public static function clientDDAInvoice(): CelcoinDDAInvoice
    {
        return new CelcoinDDAInvoice();
    }

    public static function clientDDAUser(): CelcoinDDAUser
    {
        return new CelcoinDDAUser();
    }

    public static function clientDDAWebhooks(): CelcoinDDAWebhooks
    {
        return new CelcoinDDAWebhooks();
    }

    public static function clientCelcoinReport(): CelcoinReport
    {
        return new CelcoinReport();
    }

    public static function clientElectronicTransactions(): CelcoinElectronicTransactions
    {
        return new CelcoinElectronicTransactions();
    }

    public static function clientTopups(): CelcoinTopups
    {
        return new CelcoinTopups();
    }

    public static function clientPIXQR(): CelcoinPIXQR
    {
        return new CelcoinPIXQR();
    }

    public static function clientPIXParticipants(): CelcoinPIXParticipants
    {
        return new CelcoinPIXParticipants();
    }

    public static function clientPIXDICT(): CelcoinPIXDICT
    {
        return new CelcoinPIXDICT();
    }

    public static function clientPixStaticPayment(): CelcoinPixStaticPayment
    {
        return new CelcoinPixStaticPayment();
    }

    public static function clientPixCOBV(): CelcoinPIXCOBV
    {
        return new CelcoinPIXCOBV();
    }

    public static function clientPixCOB(): CelcoinPIXCOB
    {
        return new CelcoinPIXCOB();
    }

    public static function clientBAAS(): CelcoinBAAS
    {
        return new CelcoinBAAS();
    }

    public static function clientBAASPIX(): CelcoinBAASPIX
    {
        return new CelcoinBAASPIX();
    }

    public static function clientBAASTED(): CelcoinBAASTED
    {
        return new CelcoinBAASTED();
    }

    public static function clientBAASWebhooks(): CelcoinBAASWebhooks
    {
        return new CelcoinBAASWebhooks();
    }

    public static function clientPIXDynamic(): CelcoinPIXDynamic
    {
        return new CelcoinPIXDynamic();
    }

    public static function clientPIXPayment(): CelcoinPIXPayment
    {
        return new CelcoinPIXPayment();
    }

    public static function clientPIXReceivement(): CelcoinPIXReceivement
    {
        return new CelcoinPIXReceivement();
    }

    public static function clientPIXReverse(): CelcoinPIXReverse
    {
        return new CelcoinPIXReverse();
    }

    public static function clientPixWebhooks(): CelcoinPixWebhooks
    {
        return new CelcoinPixWebhooks();
    }

    public static function clientKyc(): CelcoinKyc
    {
        return new CelcoinKyc();
    }

    public static function clientBAASBillPayment(): CelcoinBAASBillPayment
    {
        return new CelcoinBAASBillPayment();
    }

    public static function clientBAASBillet(): CelcoinBAASBillet
    {
        return new CelcoinBAASBillet();
    }
}
