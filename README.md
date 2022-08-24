# laravel-proxy-manager

[简体中文](README-zh_CN.md) | [ENGLISH](README.md)

> [Proxy Manager](https://github.com/Ocramius/ProxyManager) integration for Laravel. - Laravel 的代理管理器集成。

[![tests](https://github.com/guanguans/laravel-proxy-manager/workflows/tests/badge.svg)](https://github.com/guanguans/laravel-proxy-manager/actions)
[![check & fix styling](https://github.com/guanguans/laravel-proxy-manager/actions/workflows/php-cs-fixer.yml/badge.svg)](https://github.com/guanguans/laravel-proxy-manager/actions)
[![codecov](https://codecov.io/gh/guanguans/laravel-proxy-manager/branch/main/graph/badge.svg?token=URGFAWS6S4)](https://codecov.io/gh/guanguans/laravel-proxy-manager)
[![Latest Stable Version](https://poser.pugx.org/guanguans/laravel-proxy-manager/v)](//packagist.org/packages/guanguans/laravel-proxy-manager)
[![Total Downloads](https://poser.pugx.org/guanguans/laravel-proxy-manager/downloads)](//packagist.org/packages/guanguans/laravel-proxy-manager)
[![License](https://poser.pugx.org/guanguans/laravel-proxy-manager/license)](//packagist.org/packages/guanguans/laravel-proxy-manager)
![GitHub repo size](https://img.shields.io/github/repo-size/guanguans/laravel-proxy-manager)
![GitHub release (latest by date)](https://img.shields.io/github/v/release/guanguans/laravel-proxy-manager)

## Requirement

* PHP >= 7.4
* Laravel >= 7.0

## Installation

```shell
$ composer require guanguans/laravel-proxy-manager --prefer-dist -vvv
```

```shell
$ php artisan vendor:publish --provider="Guanguans\\LaravelProxyManager\\ProxyManagerServiceProvider"
```

## Usage

[**examples**](./tests/Facades)

### Facade methods

```php
<?php

namespace Guanguans\LaravelProxyManager\Facades;

/**
 * Create proxy.
 * @method static \ProxyManager\Proxy\AccessInterceptorInterface            createAccessInterceptorScopeLocalizerProxy(object $instance, array $prefixInterceptors = [], array $suffixInterceptors = [])
 * @method static \ProxyManager\Proxy\AccessInterceptorValueHolderInterface createAccessInterceptorValueHolderProxy(object $instance, array $prefixInterceptors = [], array $suffixInterceptors = [])
 * @method static \ProxyManager\Proxy\GhostObjectInterface                  createLazyLoadingGhostFactoryProxy(string $className, \Closure $initializer, array $proxyOptions = [])
 * @method static \ProxyManager\Proxy\VirtualProxyInterface                 createLazyLoadingValueHolderProxy(string $className, \Closure $initializer, array $proxyOptions = [])
 * @method static \ProxyManager\Proxy\NullObjectInterface                   createNullObjectProxy($instanceOrClassName)
 * @method static \ProxyManager\Proxy\RemoteObjectInterface                 createRemoteObjectProxy($instanceOrClassName, ?\ProxyManager\Factory\RemoteObject\AdapterInterface $adapter = null)
 * 
 * Bind proxy.
 * @method static void                                                      singletonLazyLoadingValueHolderProxy(string $className, ?\Closure $concrete = null)
 * @method static void                                                      bindLazyLoadingValueHolderProxy(string $className, ?\Closure $concrete = null, bool $shared = false)
 * @method static void                                                      singletonNullObjectProxy(string $className)
 * @method static void                                                      bindNullObjectProxy(string $className, bool $shared = false)
 * @method static void                                                      singletonRemoteObjectProxy(string $className, ?\ProxyManager\Factory\RemoteObject\AdapterInterface $adapter = null)
 * @method static void                                                      bindRemoteObjectProxy(string $className, ?\ProxyManager\Factory\RemoteObject\AdapterInterface $adapter = null, bool $shared = false)
 *
 * Extend to proxy.
 * @method static void                                                      extendToAccessInterceptorScopeLocalizerProxy(string $abstract, array $prefixInterceptors = [], array $suffixInterceptors = [])
 * @method static void                                                      extendToAccessInterceptorValueHolderProxy(string $abstract, array $prefixInterceptors = [], array $suffixInterceptors = [])
 * @method static void                                                      extendToLazyLoadingGhostFactoryProxy(string $abstract, \Closure $initializer, array $proxyOptions = [])
 * @method static void                                                      extendToLazyLoadingValueHolderProxy(string $abstract, \Closure $initializer, array $proxyOptions = [])
 * @method static void                                                      extendToNullObjectProxy(string $abstract)
 * @method static void                                                      extendToRemoteObjectProxy(string $abstract, ?\ProxyManager\Factory\RemoteObject\AdapterInterface $adapter = null)
 *
 * @see \Guanguans\LaravelProxyManager\ProxyManager
 */
class ProxyManager{}
```

### Binding virtual proxy example(lazy loading)

```php
<?php

namespace App;

use App\Foo;
use Guanguans\LaravelProxyManager\Facades\ProxyManager;
use SebastianBergmann\Timer\ResourceUsageFormatter;
use SebastianBergmann\Timer\Timer;

class Foo
{
    /** @var string */
    private $bar;

    public function __construct(string $bar = 'bar')
    {
        $this->bar = $bar;
        sleep(3);
    }

    public function getBar(): string
    {
        return $this->bar;
    }
}

//ProxyManager::bindLazyLoadingValueHolderProxy(Foo::class);
ProxyManager::singletonLazyLoadingValueHolderProxy(Foo::class);

$formatter = new ResourceUsageFormatter();
$timer = new Timer();
$timer->start();
$timer->start();

// The constructor of the original class is not triggered when the proxy class is initialized
dump($foo = app(Foo::class), $formatter->resourceUsage($timer->stop()));
// The constructor of the original class will only be triggered when it is actually called
dump($foo->getBar(), $formatter->resourceUsage($timer->stop()));
```

```shell
ProxyManagerGeneratedProxy\__PM__\App\Foo\Generated5320f6306ba550844e07c949e4af382d - App\Foo@proxy {#774
  -valueHolder1cdad: null
  -initializer7920c: Closure(?object &$wrappedObject, ?object $proxy, string $method, array $parameters, ?Closure &$initializer) {#758
    class: "Guanguans\LaravelProxyManager\ProxyManager"
    this: Guanguans\LaravelProxyManager\ProxyManager {#755 …}
    use: {
      $className: "App\Foo"
      $classArgs: []
    }
    file: "/Users/yaozm/Documents/develop/laravel-proxy-manager/src/ProxyManager.php"
    line: "282 to 287"
  }
}
"Time: 00:00.008, Memory: 20.00 MB"
"bar"
"Time: 00:03.025, Memory: 22.00 MB"
```

### Extend to access interceptor value holder proxy example(aop)

```php
ProxyManager::extendToAccessInterceptorValueHolderProxy(
    LogManager::class,
    [
        'error' => static function (
            object $proxy,
            LogManager $realInstance,
            string $method,
            array $parameters,
            bool &$returnEarly
        ){
            dump('Before executing the error log method.');
        }
    ],
    [
        'error' => static function (
            object $proxy,
            LogManager $realInstance,
            string $method,
            array $parameters,
            &$returnValue,
            bool &$overrideReturnValue
        ){
            dump('After executing the error log method.');
        }
    ]
);

dump($logger = app(LogManager::class));
$logger->error('What happened?');
```

```shell
ProxyManagerGeneratedProxy\__PM__\Illuminate\Log\LogManager\Generated9b66c8f3bc457c2c26acc55874d391b3 - Illuminate\Log\LogManager@proxy {#298 ▼
  -valueHolder8f21a: Illuminate\Log\LogManager {#168 ▼
    #app: Illuminate\Foundation\Application {#6 ▶}
    #channels: []
    #customCreators: array:1 [▶]
    #dateFormat: "Y-m-d H:i:s"
    #levels: array:8 [▶]
  }
  -methodPrefixInterceptors8d709: array:1 [▼
    "error" => Closure(object $proxy, LogManager $realInstance, string $method, array $parameters, bool &$returnEarly) {#280 ▶}
  ]
  -methodSuffixInterceptors2a12b: array:1 [▼
    "error" => Closure(object $proxy, LogManager $realInstance, string $method, array $parameters, &$returnValue, bool &$overrideReturnValue) {#278 ▶}
  ]
}
"Before executing the error log method."
"After executing the error log method."
```

### Commands

```shell
$ php artisan proxy:list
$ php artisan proxy:clear
```

```shell
╰─ php artisan proxy:list                                                                                       ─╯
+-------+---------------------------+-------------------------------------------+---------------------------------+
| Index | Original Class            | Proxy Class                               | Proxy Type                      |
+-------+---------------------------+-------------------------------------------+---------------------------------+
| 1     | App\Foo                   | Generated5320f6306ba550844e07c949e4af382d | Virtual Proxy                   |
| 2     | Illuminate\Log\LogManager | Generated9b66c8f3bc457c2c26acc55874d391b3 | Access Interceptor Value Holder |
+-------+---------------------------+-------------------------------------------+---------------------------------+
```

## Testing

```shell
$ composer test
```

## Changelog

Please see [CHANGELOG](CHANGELOG.md) for more information on what has changed recently.

## Contributing

Please see [CONTRIBUTING](.github/CONTRIBUTING.md) for details.

## Security Vulnerabilities

Please review [our security policy](../../security/policy) on how to report security vulnerabilities.

## Credits

* [guanguans](https://github.com/guanguans)
* [All Contributors](../../contributors)

## License

The MIT License (MIT). Please see [License File](LICENSE) for more information.
