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
use Guanguans\LaravelProxyManagerTests\TestClasses\AccessInterceptorScopeLocalizerTestClass;
use Guanguans\LaravelProxyManagerTests\TestClasses\AccessInterceptorValueHolderTestClass;
use Guanguans\LaravelProxyManagerTests\TestClasses\LazyLoadingGhostTestClass;
use Guanguans\LaravelProxyManagerTests\TestClasses\LazyLoadingValueHolderTestClass;
use Guanguans\LaravelProxyManagerTests\TestClasses\NullObjectTestClass;
use Guanguans\LaravelProxyManagerTests\TestClasses\RemoteNullObjectAdapterTestClass;
use ProxyManager\Proxy\AccessInterceptorInterface;
use ProxyManager\Proxy\AccessInterceptorValueHolderInterface;
use ProxyManager\Proxy\GhostObjectInterface;
use ProxyManager\Proxy\NullObjectInterface;
use ProxyManager\Proxy\RemoteObjectInterface;
use ProxyManager\Proxy\VirtualProxyInterface;

it('will return the proxy instance', function () {
    expect(new ProxyManager(app()))
        ->createAccessInterceptorScopeLocalizerProxy(new AccessInterceptorScopeLocalizerTestClass())
        ->toBeInstanceOf(AccessInterceptorScopeLocalizerTestClass::class)
        ->toBeInstanceOf(AccessInterceptorInterface::class)

        ->createAccessInterceptorValueHolderProxy(new AccessInterceptorValueHolderTestClass())
        ->toBeInstanceOf(AccessInterceptorValueHolderTestClass::class)
        ->toBeInstanceOf(AccessInterceptorValueHolderInterface::class)

        ->createLazyLoadingGhostFactoryProxy(LazyLoadingGhostTestClass::class, function () {})
        ->toBeInstanceOf(LazyLoadingGhostTestClass::class)
        ->toBeInstanceOf(GhostObjectInterface::class)

        ->createLazyLoadingValueHolderProxy(LazyLoadingValueHolderTestClass::class, function () {})
        ->toBeInstanceOf(LazyLoadingValueHolderTestClass::class)
        ->toBeInstanceOf(VirtualProxyInterface::class)

        ->createNullObjectProxy(NullObjectTestClass::class)
        ->toBeInstanceOf(NullObjectTestClass::class)
        ->toBeInstanceOf(NullObjectInterface::class)

        ->createRemoteObjectProxy(AbstractLocalBookObjectTestClass::class, new RemoteNullObjectAdapterTestClass())
        ->toBeInstanceOf(AbstractLocalBookObjectTestClass::class)
        ->toBeInstanceOf(RemoteObjectInterface::class);
});
