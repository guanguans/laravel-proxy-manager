# laravel-proxy-manager

[简体中文](README-zh_CN.md) | [ENGLISH](README.md)

> [Proxy Manager](https://github.com/Ocramius/ProxyManager) integration for Laravel. - Laravel 的代理管理器集成。

[![tests](https://github.com/guanguans/laravel-proxy-manager/workflows/tests/badge.svg)](https://github.com/guanguans/laravel-proxy-manager/actions)
[![check & fix styling](https://github.com/guanguans/laravel-proxy-manager/actions/workflows/php-cs-fixer.yml/badge.svg)](https://github.com/guanguans/laravel-proxy-manager/actions)
[![codecov](https://codecov.io/gh/guanguans/laravel-proxy-manager/branch/main/graph/badge.svg?token=URGFAWS6S4)](https://codecov.io/gh/guanguans/laravel-proxy-manager)
[![Latest Stable Version](https://poser.pugx.org/guanguans/laravel-proxy-manager/v)](//packagist.org/packages/guanguans/laravel-proxy-manager)
[![Total Downloads](https://poser.pugx.org/guanguans/laravel-proxy-manager/downloads)](//packagist.org/packages/guanguans/laravel-proxy-manager)
[![License](https://poser.pugx.org/guanguans/laravel-proxy-manager/license)](//packagist.org/packages/guanguans/laravel-proxy-manager)
![GitHub release (latest by date)](https://img.shields.io/github/v/release/guanguans/laravel-proxy-manager)

## 功能

* 快速创建不同类型的代理实例。
* 快速绑定不同类型的代理实例到容器。
* 快速扩展为不同类型的代理实例到容器。

## 环境要求

* PHP >= 7.4
* Laravel >= 7.0

## 安装

```shell
$ composer require guanguans/laravel-proxy-manager -vvv
```

```shell
$ php artisan vendor:publish --provider="Guanguans\\LaravelProxyManager\\ProxyManagerServiceProvider"
```

## 使用

[**测试示例**](./tests/Facades)

### 获取代理管理器实例

```php
app(\Guanguans\LaravelProxyManager\ProxyManager::class);
resolve(\Guanguans\LaravelProxyManager\ProxyManager::class);
```

### 代理管理器门面方法

```php
<?php

namespace Guanguans\LaravelProxyManager\Facades;

/**
 * 创建代理
 * @method static \ProxyManager\Proxy\AccessInterceptorInterface            createAccessInterceptorScopeLocalizerProxy(object $instance, array $prefixInterceptors = [], array $suffixInterceptors = [])
 * @method static \ProxyManager\Proxy\AccessInterceptorValueHolderInterface createAccessInterceptorValueHolderProxy(object $instance, array $prefixInterceptors = [], array $suffixInterceptors = [])
 * @method static \ProxyManager\Proxy\GhostObjectInterface                  createLazyLoadingGhostFactoryProxy(string $className, \Closure $initializer, array $proxyOptions = [])
 * @method static \ProxyManager\Proxy\VirtualProxyInterface                 createLazyLoadingValueHolderProxy(string $className, \Closure $initializer, array $proxyOptions = [])
 * @method static \ProxyManager\Proxy\NullObjectInterface                   createNullObjectProxy($instanceOrClassName)
 * @method static \ProxyManager\Proxy\RemoteObjectInterface                 createRemoteObjectProxy($instanceOrClassName, ?\ProxyManager\Factory\RemoteObject\AdapterInterface $adapter = null)
 *
 * 绑定代理
 * @method static void                                                      singletonLazyLoadingValueHolderProxy(string $className, ?\Closure $concrete = null)
 * @method static void                                                      bindLazyLoadingValueHolderProxy(string $className, ?\Closure $concrete = null, bool $shared = false)
 * @method static void                                                      singletonNullObjectProxy(string $className)
 * @method static void                                                      bindNullObjectProxy(string $className, bool $shared = false)
 * @method static void                                                      singletonRemoteObjectProxy(string $className, ?\ProxyManager\Factory\RemoteObject\AdapterInterface $adapter = null)
 * @method static void                                                      bindRemoteObjectProxy(string $className, ?\ProxyManager\Factory\RemoteObject\AdapterInterface $adapter = null, bool $shared = false)
 * 
 * 扩展为代理
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

### 绑定虚拟代理示例(懒初始化)

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

// ProxyManager::bindLazyLoadingValueHolderProxy(Foo::class);
ProxyManager::singletonLazyLoadingValueHolderProxy(Foo::class);

$formatter = new ResourceUsageFormatter();
$timer = new Timer();
$timer->start();
$timer->start();

// 初始代理类时不会触发原类的构造函数
dump($foo = app(Foo::class), $formatter->resourceUsage($timer->stop()));
// 当真正调用时才会触发原类的构造函数
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

### 扩展为访问拦截器值持有者代理示例(切面)

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

### 命令

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

## 测试

```shell
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
