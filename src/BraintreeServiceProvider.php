<?php

/*
 * This file is part of Laravel Braintree.
 *
 * (c) Brian Faust <hello@brianfaust.de>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

declare(strict_types=1);

namespace BrianFaust\Braintree;

use Illuminate\Contracts\Container\Container;
use Illuminate\Support\ServiceProvider;

class BraintreeServiceProvider extends ServiceProvider
{
    /**
     * Boot the service provider.
     */
    public function boot(): void
    {
        $source = realpath(__DIR__.'/../config/braintree.php');

        $this->publishes([$source => config_path('braintree.php')]);

        $this->mergeConfigFrom($source, 'braintree');
    }

    /**
     * Register the service provider.
     */
    public function register(): void
    {
        $this->registerFactory();
        $this->registerManager();
        $this->registerBindings();
    }

    /**
     * Register the factory class.
     */
    protected function registerFactory()
    {
        $this->app->singleton('braintree.factory', function () {
            return new BraintreeFactory();
        });

        $this->app->alias('braintree.factory', BraintreeFactory::class);
    }

    /**
     * Register the manager class.
     */
    protected function registerManager()
    {
        $this->app->singleton('braintree', function (Container $app) {
            $config = $app['config'];
            $factory = $app['braintree.factory'];

            return new BraintreeManager($config, $factory);
        });

        $this->app->alias('braintree', BraintreeManager::class);
    }

    /**
     * Register the bindings.
     */
    protected function registerBindings()
    {
        $this->app->bind('braintree.connection', function (Container $app) {
            $manager = $app['braintree'];

            return $manager->connection();
        });

        $this->app->alias('braintree.connection', Braintree::class);
    }

    /**
     * Get the services provided by the provider.
     *
     * @return string[]
     */
    public function provides(): array
    {
        return [
            'braintree',
            'braintree.factory',
            'braintree.connection',
        ];
    }
}
