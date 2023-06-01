<?php

namespace Reedware\Weather;

use Illuminate\Support\Facades\Facade;

class Weather extends Facade
{
    /**
     * Returns the registered name of the component.
     *
     * @return string
     */
    public static function getFacadeAccessor()
    {
        return 'weather';
    }
}
