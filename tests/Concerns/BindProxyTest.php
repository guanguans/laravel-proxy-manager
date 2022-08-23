<?php

/**
 * This file is part of the guanguans/laravel-proxy-manager.
 *
 * (c) guanguans <ityaozm@gmail.com>
 *
 * This source file is subject to the MIT license that is bundled.
 */

namespace Guanguans\LaravelProxyManagerTests\Concerns;

use Guanguans\LaravelProxyManager\ProxyManager;
use Guanguans\LaravelProxyManagerTests\TestClasses\AbstractLocalBookObjectTestClass;
use Guanguans\LaravelProxyManagerTests\TestClasses\NullObjectTestClass;
use Guanguans\LaravelProxyManagerTests\TestClasses\RemoteNullObjectAdapterTestClass;
use Guanguans\LaravelProxyManagerTests\TestClasses\ValueHolderTestClass;
use InvalidArgumentException;
use ProxyManager\Proxy\NullObjectInterface;
use ProxyManager\Proxy\RemoteObjectInterface;
use ProxyManager\Proxy\VirtualProxyInterface;

it('will throw `Target class [unkown] does not exist.` for `bindLazyLoadingValueHolderProxy`', function () {
    app(ProxyManager::class)->bindLazyLoadingValueHolderProxy('unkown');
})->throws(InvalidArgumentException::class, 'Target class [unkown] does not exist.');

it('will throw `Target [Guanguans\LaravelProxyManagerTests\Unkown] is not instantiable. InvalidArgumentExceptio` for `bindLazyLoadingValueHolderProxy`', function () {
    interface Unkown
    {
    }

    app(ProxyManager::class)->bindLazyLoadingValueHolderProxy(Unkown::class);
})->throws(InvalidArgumentException::class, 'Target [Guanguans\LaravelProxyManagerTests\Concerns\Unkown] is not instantiable.');

it('will not return for `bindLazyLoadingValueHolderProxy`', function () {
    expect(app(ProxyManager::class))
        ->bindLazyLoadingValueHolderProxy(ValueHolderTestClass::class)
        ->toBeNull()
        ->and(app(ValueHolderTestClass::class))
        ->toBeInstanceOf(ValueHolderTestClass::class)
        ->toBeInstanceOf(VirtualProxyInterface::class)
        ->execute()
        ->toBe('execute');
});

it('will not return for `singletonLazyLoadingValueHolderProxy`', function () {
    expect(app(ProxyManager::class))
        ->singletonLazyLoadingValueHolderProxy(ValueHolderTestClass::class)
        ->toBeNull()
        ->and(app(ValueHolderTestClass::class))
        ->toBeInstanceOf(ValueHolderTestClass::class)
        ->toBeInstanceOf(VirtualProxyInterface::class);
});

it('will not return for `bindNullObjectProxy`', function () {
    expect(app(ProxyManager::class))
        ->bindNullObjectProxy(NullObjectTestClass::class)
        ->toBeNull()
        ->and(app(NullObjectTestClass::class))
        ->toBeInstanceOf(NullObjectTestClass::class)
        ->toBeInstanceOf(NullObjectInterface::class);
});

it('will not return for `singletonNullObjectProxy`', function () {
    expect(app(ProxyManager::class))
        ->singletonNullObjectProxy(NullObjectTestClass::class)
        ->toBeNull()
        ->and(app(NullObjectTestClass::class))
        ->toBeInstanceOf(NullObjectTestClass::class)
        ->toBeInstanceOf(NullObjectInterface::class);
});

it('will not return for `bindRemoteObjectProxy`', function () {
    expect(app(ProxyManager::class))
        ->bindRemoteObjectProxy(AbstractLocalBookObjectTestClass::class, new RemoteNullObjectAdapterTestClass())
        ->toBeNull()
        ->and(app(AbstractLocalBookObjectTestClass::class))
        ->toBeInstanceOf(AbstractLocalBookObjectTestClass::class)
        ->toBeInstanceOf(RemoteObjectInterface::class);
});

it('will not return for `singletonRemoteObjectProxy`', function () {
    expect(app(ProxyManager::class))
        ->singletonRemoteObjectProxy(AbstractLocalBookObjectTestClass::class, new RemoteNullObjectAdapterTestClass())
        ->toBeNull()
        ->and(app(AbstractLocalBookObjectTestClass::class))
        ->toBeInstanceOf(AbstractLocalBookObjectTestClass::class)
        ->toBeInstanceOf(RemoteObjectInterface::class);
});
