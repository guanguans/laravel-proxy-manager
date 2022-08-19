# laravel-proxy-manager

[简体中文](README-zh_CN.md) | [ENGLISH](README.md)

> Proxy Manager integration for Laravel. - Laravel 的代理管理器集成。

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

## Usage

[**example**](./tests/Facades)

```php
use Guanguans\LaravelProxyManager\Facades\AccessInterceptorScopeLocalizerFactory;
use Guanguans\LaravelProxyManager\Facades\AccessInterceptorValueHolderFactory;
use Guanguans\LaravelProxyManager\Facades\LazyLoadingGhostFactory;
use Guanguans\LaravelProxyManager\Facades\LazyLoadingValueHolderFactory;
use Guanguans\LaravelProxyManager\Facades\NullObjectFactory;
use Guanguans\LaravelProxyManager\Facades\RemoteObjectFactory;

AccessInterceptorScopeLocalizerFactory::createProxy($instance, $prefixInterceptors, $suffixInterceptors);
AccessInterceptorValueHolderFactory::createProxy($instance, $prefixInterceptors, $suffixInterceptors);
LazyLoadingGhostFactory::createProxy($className, $initializer, $proxyOptions);
LazyLoadingValueHolderFactory::createProxy($className, $initializer, $proxyOptions);
NullObjectFactory::createProxy($instanceOrClassName);
RemoteObjectFactory::setAdapter($adapter)->createProxy($instanceOrClassName);
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
