# Laravel Braintree

> A [Braintree](https://www.braintreepayments.com) bridge for Laravel.

## Installation

Require this package, with [Composer](https://getcomposer.org/), in the root directory of your project.

```bash
$ composer require faustbrian/laravel-braintree
```

Add the service provider to `config/app.php` in the `providers` array.

```php
BrianFaust\Braintree\BraintreeServiceProvider::class
```

If you want you can use the [facade](http://laravel.com/docs/facades). Add the reference in `config/app.php` to your aliases array.

```php
'Braintree' => BrianFaust\Braintree\Facades\Braintree::class
```

## Configuration

Laravel Braintree requires connection configuration. To get started, you'll need to publish all vendor assets:

```bash
$ php artisan vendor:publish --provider="BrianFaust\Braintree\BraintreeServiceProvider"
```

This will create a `config/braintree.php` file in your app that you can modify to set your configuration. Also, make sure you check for changes to the original config file in this package between releases.

#### Default Connection Name

This option `default` is where you may specify which of the connections below you wish to use as your default connection for all work. Of course, you may use many connections at once using the manager class. The default value for this setting is `main`.

#### Braintree Connections

This option `connections` is where each of the connections are setup for your application. Example configuration has been included, but you may add as many connections as you would like.

## Usage

#### BraintreeManager

This is the class of most interest. It is bound to the ioc container as `braintree` and can be accessed using the `Facades\Braintree` facade. This class implements the ManagerInterface by extending AbstractManager. The interface and abstract class are both part of [Graham Campbell's](https://github.com/GrahamCampbell) [Laravel Manager](https://github.com/GrahamCampbell/Laravel-Manager) package, so you may want to go and checkout the docs for how to use the manager class over at that repository. Note that the connection class returned will always be an instance of `Braintree\Braintree`.

#### Facades\Braintree

This facade will dynamically pass static method calls to the `braintree` object in the ioc container which by default is the `BraintreeManager` class.

#### BraintreeServiceProvider

This class contains no public methods of interest. This class should be added to the providers array in `config/app.php`. This class will setup ioc bindings.

### Examples

Here you can see an example of just how simple this package is to use. Out of the box, the default adapter is `main`. After you enter your authentication details in the config file, it will just work:

```php
// You can alias this in config/app.php.
use BrianFaust\Braintree\Facades\Braintree;

Braintree::getTransaction()->sale([
    'amount' => '10.00',
    'paymentMethodNonce' => $nonceFromTheClient,
    'options' => ['submitForSettlement' => true]
]);
// We're done here - how easy was that, it just works!
```

The Braintree manager will behave like it is a `Braintree\Braintree`. If you want to call specific connections, you can do that with the connection method:

```php
use BrianFaust\Braintree\Facades\Braintree;

// Writing this…
Braintree::connection('main')->getCharge()->([
    'amount' => '10.00',
    'paymentMethodNonce' => $nonceFromTheClient,
    'options' => ['submitForSettlement' => true]
]);

// …is identical to writing this
Braintree::getCharge()->([
    'amount' => '10.00',
    'paymentMethodNonce' => $nonceFromTheClient,
    'options' => ['submitForSettlement' => true]
]);

// and is also identical to writing this.
Braintree::connection()->getCharge()->([
    'amount' => '10.00',
    'paymentMethodNonce' => $nonceFromTheClient,
    'options' => ['submitForSettlement' => true]
]);

// This is because the main connection is configured to be the default.
Braintree::getDefaultConnection(); // This will return main.

// We can change the default connection.
Braintree::setDefaultConnection('alternative'); // The default is now alternative.
```

If you prefer to use dependency injection over facades like me, then you can inject the manager:

```php
use BrianFaust\Braintree\BraintreeManager;

class Foo
{
    protected $braintree;

    public function __construct(BraintreeManager $braintree)
    {
        $this->braintree = $braintree;
    }

    public function bar($params)
    {
        $this->braintree->getCharge()->([
            'amount' => '10.00',
            'paymentMethodNonce' => $nonceFromTheClient,
            'options' => ['submitForSettlement' => true]
        ]);
    }
}

App::make('Foo')->bar($params);
```

## Documentation

There are other classes in this package that are not documented here. This is because the package is a Laravel wrapper of [the official Braintree package](https://github.com/braintree/braintree_php).

## Security

If you discover a security vulnerability within this package, please send an e-mail to Brian Faust at hello@brianfaust.de. All security vulnerabilities will be promptly addressed.

## License

The [The MIT License (MIT)](LICENSE). Please check the [LICENSE](LICENSE) file for more details.
