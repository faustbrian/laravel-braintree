<?php

declare(strict_types=1);

/*
 * This file is part of Laravel Braintree.
 *
 * (c) Brian Faust <hello@basecode.sh>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Artisanry\Braintree\Facades;

use Illuminate\Support\Facades\Facade;

class Braintree extends Facade
{
    /**
     * Get the registered name of the component.
     *
     * @return string
     */
    protected static function getFacadeAccessor(): string
    {
        return 'braintree';
    }
}
