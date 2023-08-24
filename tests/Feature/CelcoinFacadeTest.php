<?php

namespace WeDevBr\Celcoin\Tests\Feature;

use Illuminate\Support\Facades\App;
use WeDevBr\Celcoin\Celcoin;
use WeDevBr\Celcoin\Tests\TestCase;

class CelcoinFacadeTest extends TestCase
{

    public function testSuccess()
    {
        $instance = App::make('celcoin');
        $this->assertInstanceOf(Celcoin::class, $instance);
    }
}
