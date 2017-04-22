<?php



declare(strict_types=1);

namespace BrianFaust\Braintree;

class Braintree
{
    private $braintreeClass;

    public function __call(string $method, array $arguments)
    {
        // Remove the get*-prefix to get a class name
        $sdkClass = substr($method, 3);

        // A class has been previously called
        if ($this->braintreeClass) {
            return forward_static_call_array([$this->braintreeClass, $method], $arguments);
        }

        // Method is get* so we will store the last called class
        if (class_exists($apiClass = "Braintree\\$sdkClass")) {
            $this->braintreeClass = $apiClass;
        }

        return $this;
    }
}
