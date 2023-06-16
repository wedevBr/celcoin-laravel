<?php

namespace Tests\Integration\BillPayments;

use Carbon\Carbon;
use Tests\TestCase;
use WeDevBr\Celcoin\Clients\CelcoinBillPayment;

class OcurrencyTest extends TestCase
{

    /**
     * @return void
     */
    public function testSuccessAutorize()
    {
        $payment = new CelcoinBillPayment();
        $response = $payment->getOccurrences(Carbon::now()->subDay(7), Carbon::now());

        $this->assertNotEmpty($response);
    }
}
