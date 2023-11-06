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
     * @param string|null $mtlsPassphrase
     * @return CelcoinAssistant
     */
    public static function clientAssistant(?string $mtlsPassphrase = null): CelcoinAssistant
    {
        return new CelcoinAssistant($mtlsPassphrase);
    }

    /**
     * @param string|null $mtlsPassphrase
     * @return CelcoinBankTransfer
     */
    public static function clientBankTransfer(?string $mtlsPassphrase = null): CelcoinBankTransfer
    {
        return new CelcoinBankTransfer($mtlsPassphrase);
    }

    /**
     * @param string|null $mtlsPassphrase
     * @return CelcoinBillPayment
     */
    public static function clientBillPayment(?string $mtlsPassphrase = null): CelcoinBillPayment
    {
        return new CelcoinBillPayment($mtlsPassphrase);
    }

    /**
     * @param string|null $mtlsPassphrase
     * @return CelcoinDDAInvoice
     */
    public static function clientDDAInvoice(?string $mtlsPassphrase = null): CelcoinDDAInvoice
    {
        return new CelcoinDDAInvoice($mtlsPassphrase);
    }

    /**
     * @param string|null $mtlsPassphrase
     * @return CelcoinDDAUser
     */
    public static function clientDDAUser(?string $mtlsPassphrase = null): CelcoinDDAUser
    {
        return new CelcoinDDAUser($mtlsPassphrase);
    }

    /**
     * @param string|null $mtlsPassphrase
     * @return CelcoinDDAWebhooks
     */
    public static function clientDDAWebhooks(?string $mtlsPassphrase = null): CelcoinDDAWebhooks
    {
        return new CelcoinDDAWebhooks($mtlsPassphrase);
    }

    /**
     * @param string|null $mtlsPassphrase
     * @return CelcoinReport
     */
    public static function clientCelcoinReport(?string $mtlsPassphrase = null): CelcoinReport
    {
        return new CelcoinReport($mtlsPassphrase);
    }

    /**
     * @param string|null $mtlsPassphrase
     * @return CelcoinElectronicTransactions
     */
    public static function clientElectronicTransactions(?string $mtlsPassphrase = null): CelcoinElectronicTransactions
    {
        return new CelcoinElectronicTransactions($mtlsPassphrase);
    }

    /**
     * @param string|null $mtlsPassphrase
     * @return CelcoinTopups
     */
    public static function clientTopups(?string $mtlsPassphrase = null): CelcoinTopups
    {
        return new CelcoinTopups($mtlsPassphrase);
    }

    /**
     * @param string|null $mtlsPassphrase
     * @return CelcoinPIXQR
     */
    public static function clientPIXQR(?string $mtlsPassphrase = null): CelcoinPIXQR
    {
        return new CelcoinPIXQR($mtlsPassphrase);
    }

    /**
     * @param string|null $mtlsPassphrase
     * @return CelcoinPIXParticipants
     */
    public static function clientPIXParticipants(?string $mtlsPassphrase = null): CelcoinPIXParticipants
    {
        return new CelcoinPIXParticipants($mtlsPassphrase);
    }

    /**
     * @param string|null $mtlsPassphrase
     * @return CelcoinPIXDICT
     */
    public static function clientPIXDICT(?string $mtlsPassphrase = null): CelcoinPIXDICT
    {
        return new CelcoinPIXDICT($mtlsPassphrase);
    }

    /**
     * @param string|null $mtlsPassphrase
     * @return CelcoinPixStaticPayment
     */
    public static function clientPixStaticPayment(?string $mtlsPassphrase = null): CelcoinPixStaticPayment
    {
        return new CelcoinPixStaticPayment($mtlsPassphrase);
    }

    /**
     * @param string|null $mtlsPassphrase
     * @return CelcoinPIXCOBV
     */
    public static function clientPixCOBV(?string $mtlsPassphrase = null): CelcoinPIXCOBV
    {
        return new CelcoinPIXCOBV($mtlsPassphrase);
    }

    /**
     * @param string|null $mtlsPassphrase
     * @return CelcoinPIXCOB
     */
    public static function clientPixCOB(?string $mtlsPassphrase = null): CelcoinPIXCOB
    {
        return new CelcoinPIXCOB($mtlsPassphrase);
    }

    /**
     * @param string|null $mtlsPassphrase
     * @return CelcoinBAAS
     */
    public static function clientBAAS(?string $mtlsPassphrase = null): CelcoinBAAS
    {
        return new CelcoinBAAS($mtlsPassphrase);
    }

    /**
     * @param string|null $mtlsPassphrase
     * @return CelcoinBAASPIX
     */
    public static function clientBAASPIX(?string $mtlsPassphrase = null): CelcoinBAASPIX
    {
        return new CelcoinBAASPIX($mtlsPassphrase);
    }

    /**
     * @param string|null $mtlsPassphrase
     * @return CelcoinBAASTED
     */
    public static function clientBAASTED(?string $mtlsPassphrase = null): CelcoinBAASTED
    {
        return new CelcoinBAASTED($mtlsPassphrase);
    }

    /**
     * @param string|null $mtlsPassphrase
     * @return CelcoinBAASWebhooks
     */
    public static function clientBAASWebhooks(?string $mtlsPassphrase = null): CelcoinBAASWebhooks
    {
        return new CelcoinBAASWebhooks($mtlsPassphrase);
    }

    /**
     * @param string|null $mtlsPassphrase
     * @return CelcoinPIXDynamic
     */
    public static function clientPIXDynamic(?string $mtlsPassphrase = null): CelcoinPIXDynamic
    {
        return new CelcoinPIXDynamic($mtlsPassphrase);
    }

    /**
     * @param string|null $mtlsPassphrase
     * @return CelcoinPIXPayment
     */
    public static function clientPIXPayment(?string $mtlsPassphrase = null): CelcoinPIXPayment
    {
        return new CelcoinPIXPayment($mtlsPassphrase);
    }

    /**
     * @param string|null $mtlsPassphrase
     * @return CelcoinPIXReceivement
     */
    public static function clientPIXReceivement(?string $mtlsPassphrase = null): CelcoinPIXReceivement
    {
        return new CelcoinPIXReceivement($mtlsPassphrase);
    }

    /**
     * @param string|null $mtlsPassphrase
     * @return CelcoinPIXReverse
     */
    public static function clientPIXReverse(?string $mtlsPassphrase = null): CelcoinPIXReverse
    {
        return new CelcoinPIXReverse($mtlsPassphrase);
    }

    /**
     * @param string|null $mtlsPassphrase
     * @return CelcoinPixWebhooks
     */
    public static function clientPixWebhooks(?string $mtlsPassphrase = null): CelcoinPixWebhooks
    {
        return new CelcoinPixWebhooks($mtlsPassphrase);
    }

    /**
     * @param string|null $mtlsPassphrase
     * @return CelcoinKyc
     */
    public static function clientKyc(?string $mtlsPassphrase = null): CelcoinKyc
    {
        return new CelcoinKyc($mtlsPassphrase);
    }

    /**
     * @param string|null $mtlsPassphrase
     * @return CelcoinBAASBillPayment
     */
    public static function clientBAASBillPayment(?string $mtlsPassphrase = null): CelcoinBAASBillPayment
    {
        return new CelcoinBAASBillPayment($mtlsPassphrase);
    }

    /**
     * @param string|null $mtlsPassphrase
     * @return CelcoinBAASBillet
     */
    public static function clientBAASBillet(?string $mtlsPassphrase = null): CelcoinBAASBillet
    {
        return new CelcoinBAASBillet($mtlsPassphrase);
    }
}
