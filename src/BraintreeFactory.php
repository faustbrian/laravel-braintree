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

use Braintree\Configuration;
use InvalidArgumentException;

class BraintreeFactory
{
    /**
     * Make a new Braintree client.
     *
     * @param array $config
     *
     * @return \Braintree\Braintree
     */
    public function make(array $config): Braintree
    {
        $config = $this->getConfig($config);

        return $this->getClient($config);
    }

    /**
     * Get the configuration data.
     *
     * @param string[] $config
     *
     * @throws \InvalidArgumentException
     *
     * @return array
     */
    protected function getConfig(array $config): array
    {
        $keys = ['environment', 'merchant_id', 'public_key', 'private_key'];

        foreach ($keys as $key) {
            if (!array_key_exists($key, $config)) {
                throw new InvalidArgumentException("Missing configuration key [$key].");
            }
        }

        return array_only($config, ['environment', 'merchant_id', 'public_key', 'private_key']);
    }

    /**
     * Get the Braintree client.
     *
     * @param array $auth
     *
     * @return \Braintree\Braintree
     */
    protected function getClient(array $auth): Braintree
    {
        Configuration::environment($auth['environment']);
        Configuration::merchantId($auth['merchant_id']);
        Configuration::publicKey($auth['public_key']);
        Configuration::privateKey($auth['private_key']);

        return new Braintree();
    }
}
