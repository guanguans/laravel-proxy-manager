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

## 环境要求

* PHP >= 7.4
* Laravel >= 7.0

## 安装

```bash
$ composer require guanguans/laravel-proxy-manager --prefer-dist -vvv
```

## 使用

[**示例**](./tests/Facades)

```php
use Guanguans\LaravelProxyManager\Facades\ProxyManager;

ProxyManager::createAccessInterceptorScopeLocalizerProxy($instance, $prefixInterceptors, $suffixInterceptors);
ProxyManager::createAccessInterceptorValueHolderProxy($instance, $prefixInterceptors, $suffixInterceptors);
ProxyManager::createLazyLoadingGhostFactoryProxy($className, $initializer, $proxyOptions);
ProxyManager::createLazyLoadingValueHolderProxy($className, $initializer, $proxyOptions);
ProxyManager::createNullObjectProxy($instanceOrClassName);
ProxyManager::createRemoteObjectProxy($instanceOrClassName, $adapter);
```

## 测试

```bash
$ composer test
```

## 变更日志

请参阅 [CHANGELOG](CHANGELOG.md) 获取最近有关更改的更多信息。

## 贡献指南

请参阅 [CONTRIBUTING](.github/CONTRIBUTING.md) 有关详细信息。

## 安全漏洞

请查看[我们的安全政策](../../security/policy)了解如何报告安全漏洞。

## 贡献者

* [guanguans](https://github.com/guanguans)
* [所有贡献者](../../contributors)

## 协议

MIT 许可证（MIT）。有关更多信息，请参见[协议文件](LICENSE)。
