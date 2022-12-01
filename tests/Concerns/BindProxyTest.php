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
use Illuminate\Contracts\Container\BindingResolutionException;
use ProxyManager\Proxy\NullObjectInterface;
use ProxyManager\Proxy\RemoteObjectInterface;
use ProxyManager\Proxy\VirtualProxyInterface;

it('will throw `Target class [unkown] does not exist.` for `bindLazyLoadingValueHolderProxy`', function (): void {
    app(ProxyManager::class)->bindLazyLoadingValueHolderProxy('unkown');
})->throws(\InvalidArgumentException::class, 'Target class [unkown] does not exist.');

it('will throw `Target [Guanguans\LaravelProxyManagerTests\Unkown] is not instantiable. InvalidArgumentExceptio` for `bindLazyLoadingValueHolderProxy`', function (): void {
    abstract class Unkown
    {
        public function kown(): string
        {
            return __FUNCTION__;
        }

        abstract public function unkown();
    }

    app(ProxyManager::class)->bindLazyLoadingValueHolderProxy(Unkown::class);
    app(Unkown::class)->kown();
})->throws(BindingResolutionException::class, 'Target [Guanguans\LaravelProxyManagerTests\Concerns\Unkown] is not instantiable.');

it('will not return for `bindLazyLoadingValueHolderProxy`', function (): void {
    expect(app(ProxyManager::class))
        ->bindLazyLoadingValueHolderProxy(ValueHolderTestClass::class)
        ->toBeNull()
        ->and(app(ValueHolderTestClass::class))
        ->toBeInstanceOf(ValueHolderTestClass::class)
        ->toBeInstanceOf(VirtualProxyInterface::class)
        ->execute()
        ->toBe('execute');
});

it('will not return for `singletonLazyLoadingValueHolderProxy`', function (): void {
    expect(app(ProxyManager::class))
        ->singletonLazyLoadingValueHolderProxy(ValueHolderTestClass::class)
        ->toBeNull()
        ->and(app(ValueHolderTestClass::class))
        ->toBeInstanceOf(ValueHolderTestClass::class)
        ->toBeInstanceOf(VirtualProxyInterface::class);
});

it('will throw `Target class [unkown] does not exist.` for `bindNullObjectProxy`', function (): void {
    app(ProxyManager::class)->bindNullObjectProxy('unkown');
})->throws(\InvalidArgumentException::class, 'Target class [unkown] does not exist.');

it('will not return for `bindNullObjectProxy`', function (): void {
    expect(app(ProxyManager::class))
        ->bindNullObjectProxy(NullObjectTestClass::class)
        ->toBeNull()
        ->and(app(NullObjectTestClass::class))
        ->toBeInstanceOf(NullObjectTestClass::class)
        ->toBeInstanceOf(NullObjectInterface::class);
});

it('will not return for `singletonNullObjectProxy`', function (): void {
    expect(app(ProxyManager::class))
        ->singletonNullObjectProxy(NullObjectTestClass::class)
        ->toBeNull()
        ->and(app(NullObjectTestClass::class))
        ->toBeInstanceOf(NullObjectTestClass::class)
        ->toBeInstanceOf(NullObjectInterface::class);
});

it('will throw `Target class [unkown] does not exist.` for `bindRemoteObjectProxy`', function (): void {
    app(ProxyManager::class)->bindRemoteObjectProxy('unkown');
})->throws(\InvalidArgumentException::class, 'Target class [unkown] does not exist.');

it('will not return for `bindRemoteObjectProxy`', function (): void {
    expect(app(ProxyManager::class))
        ->bindRemoteObjectProxy(AbstractLocalBookObjectTestClass::class, new RemoteNullObjectAdapterTestClass())
        ->toBeNull()
        ->and(app(AbstractLocalBookObjectTestClass::class))
        ->toBeInstanceOf(AbstractLocalBookObjectTestClass::class)
        ->toBeInstanceOf(RemoteObjectInterface::class);
});

it('will not return for `singletonRemoteObjectProxy`', function (): void {
    expect(app(ProxyManager::class))
        ->singletonRemoteObjectProxy(AbstractLocalBookObjectTestClass::class, new RemoteNullObjectAdapterTestClass())
        ->toBeNull()
        ->and(app(AbstractLocalBookObjectTestClass::class))
        ->toBeInstanceOf(AbstractLocalBookObjectTestClass::class)
        ->toBeInstanceOf(RemoteObjectInterface::class);
});
