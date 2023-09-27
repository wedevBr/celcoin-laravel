<?php

namespace WeDevBr\Celcoin\Tests\Feature;

use Illuminate\Support\Facades\Event;
use Illuminate\Support\Facades\Http;
use WeDevBr\Celcoin\Auth\Auth;
use WeDevBr\Celcoin\Events\CelcoinAuthenticatedEvent;
use WeDevBr\Celcoin\Tests\GlobalStubs;
use WeDevBr\Celcoin\Tests\TestCase;

class CelcoinAuthEventFiredTest extends TestCase
{

    public function testSuccess()
    {
        Event::fake();

        Http::fake(
            [
                config('celcoin.login_url') => GlobalStubs::loginResponse(),
            ],
        );

        Auth::login()->getToken();

        Event::assertDispatched(CelcoinAuthenticatedEvent::class);
    }
}
