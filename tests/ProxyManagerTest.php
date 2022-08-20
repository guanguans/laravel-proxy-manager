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
use ProxyManager\Factory\RemoteObject\AdapterInterface;
use ProxyManager\Proxy\AccessInterceptorInterface;
use ProxyManager\Proxy\AccessInterceptorValueHolderInterface;
use ProxyManager\Proxy\GhostObjectInterface;
use ProxyManager\Proxy\NullObjectInterface;
use ProxyManager\Proxy\RemoteObjectInterface;
use ProxyManager\Proxy\VirtualProxyInterface;

dataset('proxyManagers', [new ProxyManager()]);

it('will return instance of `ProxyInterface`', function (ProxyManager $proxyManager) {
    expect($proxyManager)
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
})->with('proxyManagers');
