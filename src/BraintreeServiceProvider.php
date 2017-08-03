<?php

declare(strict_types=1);

/*
 * This file is part of Laravel Braintree.
 *
 * (c) Brian Faust <hello@brianfaust.de>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace BrianFaust\Braintree;

use Illuminate\Support\ServiceProvider;
use Illuminate\Contracts\Container\Container;

class BraintreeServiceProvider extends ServiceProvider
{
    /**
     * Boot the service provider.
     */
    public function boot()
    {
        $this->publishes([
            __DIR__.'/../config/braintree.php' => config_path('braintree.php'),
        ]);
    }

    /**
     * Register the service provider.
     */
    public function register()
    {
        $this->mergeConfigFrom(__DIR__.'/../config/braintree.php', 'braintree');

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
