<?php

namespace Tests\Feature;

use Illuminate\Support\Facades\App;
use Tests\TestCase;
use WeDevBr\Celcoin\Celcoin;

class CelcoinFacadeTest extends TestCase
{

    public function testSuccess()
    {
        $instance = App::make('celcoin');
        $this->assertInstanceOf(Celcoin::class, $instance);
    }
}
