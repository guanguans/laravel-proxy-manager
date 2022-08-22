<?php

/**
 * This file is part of the guanguans/laravel-proxy-manager.
 *
 * (c) guanguans <ityaozm@gmail.com>
 *
 * This source file is subject to the MIT license that is bundled.
 */

namespace Guanguans\LaravelProxyManager\Facades;

use Illuminate\Support\Facades\Facade;

/**
 * @method static \ProxyManager\Proxy\AccessInterceptorInterface            createAccessInterceptorScopeLocalizerProxy(object $instance, array $prefixInterceptors = [], array $suffixInterceptors = [])
 * @method static \ProxyManager\Proxy\AccessInterceptorValueHolderInterface createAccessInterceptorValueHolderProxy(object $instance, array $prefixInterceptors = [], array $suffixInterceptors = [])
 * @method static \ProxyManager\Proxy\GhostObjectInterface                  createLazyLoadingGhostFactoryProxy(string $className, \Closure $initializer, array $proxyOptions = [])
 * @method static \ProxyManager\Proxy\VirtualProxyInterface                 createLazyLoadingValueHolderProxy(string $className, \Closure $initializer, array $proxyOptions = [])
 * @method static \ProxyManager\Proxy\NullObjectInterface                   createNullObjectProxy($instanceOrClassName)
 * @method static \ProxyManager\Proxy\RemoteObjectInterface                 createRemoteObjectProxy($instanceOrClassName, ?\ProxyManager\Factory\RemoteObject\AdapterInterface $adapter = null)
 * @method static void                                                      singletonLazyLoadingValueHolderProxy(string $abstract, ?\Closure $concrete = null, ?string $className = null, ?\Closure $initializer = null, array $proxyOptions = [])
 * @method static void                                                      bindLazyLoadingValueHolderProxy(string $abstract, ?\Closure $concrete = null, $shared = false, ?string $className = null, ?\Closure $initializer = null, array $proxyOptions = [])
 *
 * @mixin \Guanguans\LaravelProxyManager\ProxyManager
 *
 * @see \Guanguans\LaravelProxyManager\ProxyManager
 */
class ProxyManager extends Facade
{
    protected static function getFacadeAccessor()
    {
        return \Guanguans\LaravelProxyManager\ProxyManager::class;
    }
}
