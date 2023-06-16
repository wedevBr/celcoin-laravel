<?php

namespace WeDevBr\Celcoin\Facades;

use Illuminate\Support\Facades\Facade;

class CelcoinFacade extends Facade
{
    /**
     * Get the registered name of the component.
     *
     * @return string
     */
    protected static function getFacadeAccessor()
    {
        return 'celcoin';
    }
}
