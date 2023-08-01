<?php

namespace Tests\Feature;

use Illuminate\Support\Facades\Event;
use Illuminate\Support\Facades\Http;
use Tests\GlobalStubs;
use Tests\TestCase;
use WeDevBr\Celcoin\Auth\Auth;
use WeDevBr\Celcoin\Events\CelcoinAuthenticatedEvent;

class CelcoinAuthEventFiredTest extends TestCase
{

    public function testSuccess()
    {
        Event::fake();

        Http::fake(
            [
                config('celcoin.login_url') => GlobalStubs::loginResponse()
            ]
        );

        Auth::login()->getToken();

        Event::assertDispatched(CelcoinAuthenticatedEvent::class);
    }
}
