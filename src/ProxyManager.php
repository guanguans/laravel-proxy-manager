<?php

/**
 * This file is part of the guanguans/laravel-proxy-manager.
 *
 * (c) guanguans <ityaozm@gmail.com>
 *
 * This source file is subject to the MIT license that is bundled.
 */

namespace Guanguans\LaravelProxyManager;

use Closure;
use Guanguans\LaravelProxyManager\Facades\AccessInterceptorScopeLocalizerFactory;
use Guanguans\LaravelProxyManager\Facades\AccessInterceptorValueHolderFactory;
use Guanguans\LaravelProxyManager\Facades\LazyLoadingGhostFactory;
use Guanguans\LaravelProxyManager\Facades\LazyLoadingValueHolderFactory;
use Guanguans\LaravelProxyManager\Facades\NullObjectFactory;
use Guanguans\LaravelProxyManager\Facades\RemoteObjectFactory;
use ProxyManager\Factory\RemoteObject\AdapterInterface;
use ProxyManager\Proxy\AccessInterceptorInterface;
use ProxyManager\Proxy\AccessInterceptorValueHolderInterface;
use ProxyManager\Proxy\GhostObjectInterface;
use ProxyManager\Proxy\NullObjectInterface;
use ProxyManager\Proxy\RemoteObjectInterface;
use ProxyManager\Proxy\VirtualProxyInterface;

class ProxyManager
{
    public function createAccessInterceptorScopeLocalizerProxy(object $instance, array $prefixInterceptors = [], array $suffixInterceptors = []): AccessInterceptorInterface
    {
        return AccessInterceptorScopeLocalizerFactory::createProxy($instance, $prefixInterceptors, $suffixInterceptors);
    }

    public function createAccessInterceptorValueHolderProxy(object $instance, array $prefixInterceptors = [], array $suffixInterceptors = []): AccessInterceptorValueHolderInterface
    {
        return AccessInterceptorValueHolderFactory::createProxy($instance, $prefixInterceptors, $suffixInterceptors);
    }

    public function createLazyLoadingGhostFactoryProxy(string $className, Closure $initializer, array $proxyOptions = []): GhostObjectInterface
    {
        return LazyLoadingGhostFactory::createProxy($className, $initializer, $proxyOptions);
    }

    public function createLazyLoadingValueHolderProxy(string $className, Closure $initializer, array $proxyOptions = []): VirtualProxyInterface
    {
        return LazyLoadingValueHolderFactory::createProxy($className, $initializer, $proxyOptions);
    }

    public function createNullObjectProxy($instanceOrClassName): NullObjectInterface
    {
        return NullObjectFactory::createProxy($instanceOrClassName);
    }

    public function createRemoteObjectProxy(AdapterInterface $adapter, $instanceOrClassName): RemoteObjectInterface
    {
        return RemoteObjectFactory::setAdapter($adapter)->createProxy($instanceOrClassName);
    }
}
