<?php

namespace Tests\Integration\BillPayments;

use Tests\TestCase;
use WeDevBr\Celcoin\Clients\CelcoinBillPayment;
use WeDevBr\Celcoin\Types\BillPayments\Authorize;

class AutorizeTest extends TestCase
{

    /**
     * @return void
     */
    public function testSuccessAutorize()
    {
        $payment = new CelcoinBillPayment();
        $response = $payment->authorize(new Authorize([
            "externalTerminal" => "teste2",
            "externalNSU" => 1234,
            "barCode" => [
                "type" => 2,
                "digitable" => "23793381286008301352856000063307789840000150000",
                "barCode" => "",
            ]
        ]));
        $this->assertTrue($payment instanceof CelcoinBillPayment);

        $this->assertNotEmpty($response);
    }
}
