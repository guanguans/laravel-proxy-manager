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

```bash
$ composer require guanguans/laravel-proxy-manager --prefer-dist -vvv
```

```bash
$ php artisan vendor:publish --provider="Guanguans\\LaravelProxyManager\\ProxyManagerServiceProvider"
```

## Usage

[**examples**](./tests/Facades)

### Create proxy

```php
<?php

use Guanguans\LaravelProxyManager\Facades\ProxyManager;

ProxyManager::createAccessInterceptorScopeLocalizerProxy($instance, $prefixInterceptors, $suffixInterceptors);
ProxyManager::createAccessInterceptorValueHolderProxy($instance, $prefixInterceptors, $suffixInterceptors);
ProxyManager::createLazyLoadingGhostFactoryProxy($className, $initializer, $proxyOptions);
ProxyManager::createLazyLoadingValueHolderProxy($className, $initializer, $proxyOptions);
ProxyManager::createNullObjectProxy($instanceOrClassName);
ProxyManager::createRemoteObjectProxy($instanceOrClassName, $adapter);
```

### Bind noop virtual proxy

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

```bash
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

### Commands

```bash
$ php artisan proxy:list
$ php artisan proxy:clear
```

## Testing

```bash
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
