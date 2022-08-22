<?php

/**
 * This file is part of the guanguans/laravel-proxy-manager.
 *
 * (c) guanguans <ityaozm@gmail.com>
 *
 * This source file is subject to the MIT license that is bundled.
 */

namespace Guanguans\LaravelProxyManagerTests;

use Guanguans\LaravelProxyManager\ProxyManager;
use Guanguans\LaravelProxyManagerTests\TestClasses\AccessInterceptorScopeLocalizerTestClass;
use Guanguans\LaravelProxyManagerTests\TestClasses\AccessInterceptorValueHolderTestClass;
use Guanguans\LaravelProxyManagerTests\TestClasses\LazyLoadingGhostTestClass;
use Guanguans\LaravelProxyManagerTests\TestClasses\LazyLoadingValueHolderTestClass;
use Guanguans\LaravelProxyManagerTests\TestClasses\LocalObjectTestClass;
use Guanguans\LaravelProxyManagerTests\TestClasses\NullObjectTestClass;
use Guanguans\LaravelProxyManagerTests\TestClasses\ValueHolderTestClass;
use InvalidArgumentException;
use ProxyManager\Factory\RemoteObject\AdapterInterface;
use ProxyManager\Proxy\AccessInterceptorInterface;
use ProxyManager\Proxy\AccessInterceptorValueHolderInterface;
use ProxyManager\Proxy\GhostObjectInterface;
use ProxyManager\Proxy\NullObjectInterface;
use ProxyManager\Proxy\RemoteObjectInterface;
use ProxyManager\Proxy\VirtualProxyInterface;

it('will return instance of `ProxyInterface`', function () {
    expect(new ProxyManager(app()))
        ->createAccessInterceptorScopeLocalizerProxy(new AccessInterceptorScopeLocalizerTestClass())
        ->toBeInstanceOf(AccessInterceptorInterface::class)
        ->createAccessInterceptorValueHolderProxy(new AccessInterceptorValueHolderTestClass())
        ->toBeInstanceOf(AccessInterceptorValueHolderInterface::class)
        ->createLazyLoadingGhostFactoryProxy(LazyLoadingGhostTestClass::class, function () {})
        ->toBeInstanceOf(GhostObjectInterface::class)
        ->createLazyLoadingValueHolderProxy(LazyLoadingValueHolderTestClass::class, function () {})
        ->toBeInstanceOf(VirtualProxyInterface::class)
        ->createNullObjectProxy(NullObjectTestClass::class)
        ->toBeInstanceOf(NullObjectInterface::class)
        ->createRemoteObjectProxy(LocalObjectTestClass::class, new class() implements AdapterInterface {
            public function call(string $wrappedClass, string $method, array $params = [])
            {
            }
        })
        ->toBeInstanceOf(RemoteObjectInterface::class);
});

it('will throw `Target class [unkown] does not exist. InvalidArgumentException` for `bindNoopVirtualProxy`', function () {
    (new ProxyManager(app()))->bindNoopVirtualProxy('unkown');
})->throws(InvalidArgumentException::class, 'Target class [unkown] does not exist.');

it('will throw `Target [Guanguans\LaravelProxyManagerTests\Unkown] is not instantiable. InvalidArgumentExceptio` for `bindNoopVirtualProxy`', function () {
    interface Unkown
    {
    }

    (new ProxyManager(app()))->bindNoopVirtualProxy(Unkown::class);
})->throws(InvalidArgumentException::class, 'Target [Guanguans\LaravelProxyManagerTests\Unkown] is not instantiable.');

it('will not return for `bindNoopVirtualProxy`', function () {
    expect((new ProxyManager(app())))
        ->bindNoopVirtualProxy(ValueHolderTestClass::class)
        ->toBeNull();

    expect(app(ValueHolderTestClass::class))
        ->toBeInstanceOf(ValueHolderTestClass::class)
        ->toBeInstanceOf(VirtualProxyInterface::class);

    expect(app(ValueHolderTestClass::class))
        ->execute()
        ->toBe('execute');
});

it('will not return for `singletonNoopVirtualProxy`', function () {
    expect((new ProxyManager(app())))
        ->singletonNoopVirtualProxy(ValueHolderTestClass::class)
        ->toBeNull();

    expect(app(ValueHolderTestClass::class))
        ->toBeInstanceOf(ValueHolderTestClass::class)
        ->toBeInstanceOf(VirtualProxyInterface::class);
});
