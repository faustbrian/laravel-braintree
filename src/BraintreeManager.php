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

namespace Artisanry\Braintree;

use GrahamCampbell\Manager\AbstractManager;
use Illuminate\Contracts\Config\Repository;

class BraintreeManager extends AbstractManager
{
    /**
     * The factory instance.
     *
     * @var \Artisanry\Braintree\BraintreeFactory
     */
    private $factory;

    /**
     * Create a new Braintree manager instance.
     *
     * @param \Illuminate\Contracts\Config\Repository $config
     * @param \Artisanry\Braintree\BraintreeFactory   $factory
     */
    public function __construct(Repository $config, BraintreeFactory $factory)
    {
        parent::__construct($config);

        $this->factory = $factory;
    }

    /**
     * Create the connection instance.
     *
     * @param array $config
     *
     * @return mixed
     */
    protected function createConnection(array $config): Braintree
    {
        return $this->factory->make($config);
    }

    /**
     * Get the configuration name.
     *
     * @return string
     */
    protected function getConfigName(): string
    {
        return 'laravel-braintree';
    }

    /**
     * Get the factory instance.
     *
     * @return \Artisanry\Braintree\BraintreeFactory
     */
    public function getFactory(): BraintreeFactory
    {
        return $this->factory;
    }
}
