<?php

namespace WeDevBr\Celcoin\Tests\Feature;

use WeDevBr\Celcoin\Celcoin;
use WeDevBr\Celcoin\Clients\CelcoinAssistant;
use WeDevBr\Celcoin\Clients\CelcoinBAAS;
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
use WeDevBr\Celcoin\Clients\CelcoinPIXQR;
use WeDevBr\Celcoin\Clients\CelcoinPixStaticPayment;
use WeDevBr\Celcoin\Clients\CelcoinReport;
use WeDevBr\Celcoin\Clients\CelcoinTopups;
use WeDevBr\Celcoin\Tests\TestCase;

class CelcoinClientInstancesTest extends TestCase
{
    public function testSuccessCreateInstanceAssistant()
    {
        $instance = Celcoin::clientAssistant();
        $this->assertInstanceOf(CelcoinAssistant::class, $instance);
    }

    public function testSuccessCreateInstanceBankTransfer()
    {
        $instance = Celcoin::clientBankTransfer();
        $this->assertInstanceOf(CelcoinBankTransfer::class, $instance);
    }

    public function testSuccessCreateInstanceBillPayment()
    {
        $instance = Celcoin::clientBillPayment();
        $this->assertInstanceOf(CelcoinBillPayment::class, $instance);
    }

    public function testSuccessCreateInstanceDDAInvoice()
    {
        $instance = Celcoin::clientDDAInvoice();
        $this->assertInstanceOf(CelcoinDDAInvoice::class, $instance);
    }

    public function testSuccessCreateInstanceDDAUser()
    {
        $instance = Celcoin::clientDDAUser();
        $this->assertInstanceOf(CelcoinDDAUser::class, $instance);
    }

    public function testSuccessCreateInstanceDDAWebhooks()
    {
        $instance = Celcoin::clientDDAWebhooks();
        $this->assertInstanceOf(CelcoinDDAWebhooks::class, $instance);
    }

    public function testSuccessCreateInstanceCelcoinReport()
    {
        $instance = Celcoin::clientCelcoinReport();
        $this->assertInstanceOf(CelcoinReport::class, $instance);
    }

    public function testSuccessCreateInstanceElectronicTransactions()
    {
        $instance = Celcoin::clientElectronicTransactions();
        $this->assertInstanceOf(CelcoinElectronicTransactions::class, $instance);
    }

    public function testSuccessCreateInstanceTopups()
    {
        $instance = Celcoin::clientTopups();
        $this->assertInstanceOf(CelcoinTopups::class, $instance);
    }

    public function testSuccessCreateInstancePIXQR()
    {
        $instance = Celcoin::clientPIXQR();
        $this->assertInstanceOf(CelcoinPIXQR::class, $instance);
    }

    public function testSuccessCreateInstancePIXParticipants()
    {
        $instance = Celcoin::clientPIXParticipants();
        $this->assertInstanceOf(CelcoinPIXParticipants::class, $instance);
    }

    public function testSuccessCreateInstancePIXDICT()
    {
        $instance = Celcoin::clientPIXDICT();
        $this->assertInstanceOf(CelcoinPIXDICT::class, $instance);
    }

    public function testSuccessCreateInstancePixStaticPayment()
    {
        $instance = Celcoin::clientPixStaticPayment();
        $this->assertInstanceOf(CelcoinPixStaticPayment::class, $instance);
    }

    public function testSuccessCreateInstancePixCOBV()
    {
        $instance = Celcoin::clientPixCOBV();
        $this->assertInstanceOf(CelcoinPIXCOBV::class, $instance);
    }

    public function testSuccessCreateInstancePixCOB()
    {
        $instance = Celcoin::clientPixCOB();
        $this->assertInstanceOf(CelcoinPIXCOB::class, $instance);
    }

    public function testSuccessCreateInstanceBAAS()
    {
        $instance = Celcoin::clientBAAS();
        $this->assertInstanceOf(CelcoinBAAS::class, $instance);
    }

    public function testSuccessCreateInstanceBAASPIX()
    {
        $instance = Celcoin::clientBAASPIX();
        $this->assertInstanceOf(CelcoinBAASPIX::class, $instance);
    }

    public function testSuccessCreateInstanceBAASTED()
    {
        $instance = Celcoin::clientBAASTED();
        $this->assertInstanceOf(CelcoinBAASTED::class, $instance);
    }

    public function testSuccessCreateInstanceBAASWebhooks()
    {
        $instance = Celcoin::clientBAASWebhooks();
        $this->assertInstanceOf(CelcoinBAASWebhooks::class, $instance);
    }

    public function testSuccessCreateInstancePIXDynamic()
    {
        $instance = Celcoin::clientPIXDynamic();
        $this->assertInstanceOf(CelcoinPIXDynamic::class, $instance);
    }

    public function testSuccessCreateInstanceKyc()
    {
        $instance = Celcoin::clientKyc();
        $this->assertInstanceOf(CelcoinKyc::class, $instance);
    }

    public function testSuccessCreateBaasBillPayment()
    {
        $instance = Celcoin::clientBAASBillPayment();
        $this->assertInstanceOf(CelcoinBAASBillPayment::class, $instance);
    }

    public function testSuccessCreteBaasWebhooks()
    {
        $instance = Celcoin::clientBAASWebhooks();
        $this->assertInstanceOf(CelcoinBAASWebhooks::class, $instance);
    }
}
