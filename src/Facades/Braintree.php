<?php

namespace BrianFaust\Braintree\Facades;

use Illuminate\Support\Facades\Facade;

class Braintree extends Facade
{
    /**
     * Get the registered name of the component.
     *
     * @return string
     */
    protected static function getFacadeAccessor()
    {
        return 'braintree';
    }
}
