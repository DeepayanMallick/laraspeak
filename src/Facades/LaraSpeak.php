<?php

namespace Deepayan\LaraSpeak\Facades;

use Illuminate\Support\Facades\Facade;

class LaraSpeak extends Facade
{
    /**
     * Get the registered name of the component.
     *
     * @return string
     */
    protected static function getFacadeAccessor()
    {
        return 'laraspeak';
    }
}
