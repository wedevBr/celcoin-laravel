<?php

namespace WeDevBr\Celcoin;

use WeDevBr\Celcoin\Clients\CelcoinAssistant;
use WeDevBr\Celcoin\Clients\CelcoinBankTransfer;
use WeDevBr\Celcoin\Clients\CelcoinBillPayment;
use WeDevBr\Celcoin\Clients\CelcoinDDAInvoice;
use WeDevBr\Celcoin\Clients\CelcoinDDAUser;
use WeDevBr\Celcoin\Clients\CelcoinDDAWebhooks;
use WeDevBr\Celcoin\Clients\CelcoinElectronicTransactions;
use WeDevBr\Celcoin\Clients\CelcoinInternationalTopups;
use WeDevBr\Celcoin\Clients\CelcoinPIXParticipants;
use WeDevBr\Celcoin\Clients\CelcoinPIXQR;
use WeDevBr\Celcoin\Clients\CelcoinTopups;

/**
 * Class Celcoin
 * @package WeDevBr\Celcoin
 */
class Celcoin
{

    public static function clientAssistant(?string $mtlsPassphrase)
    {
        return new CelcoinAssistant($mtlsPassphrase);
    }

    public static function clientBankTransfer(?string $mtlsPassphrase)
    {
        return new CelcoinBankTransfer($mtlsPassphrase);
    }

    public static function clientBillPayment(?string $mtlsPassphrase)
    {
        return new CelcoinBillPayment($mtlsPassphrase);
    }

    public static function clientDDAInvoice(?string $mtlsPassphrase)
    {
        return new CelcoinDDAInvoice($mtlsPassphrase);
    }

    public static function clientDDAUser(?string $mtlsPassphrase)
    {
        return new CelcoinDDAUser($mtlsPassphrase);
    }

    public static function clientDDAWebhooks(?string $mtlsPassphrase)
    {
        return new CelcoinDDAWebhooks($mtlsPassphrase);
    }

    public static function clientElectronicTransactions(?string $mtlsPassphrase)
    {
        return new CelcoinElectronicTransactions($mtlsPassphrase);
    }

    public static function clientInternationalTopups(?string $mtlsPassphrase)
    {
        return new CelcoinInternationalTopups($mtlsPassphrase);
    }

    public static function clientTopups(?string $mtlsPassphrase)
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
}
