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
 * @method static void                                                      singletonLazyLoadingValueHolderProxy(string $className, ?\Closure $concrete = null)
 * @method static void                                                      bindLazyLoadingValueHolderProxy(string $className, ?\Closure $concrete = null, bool $shared = false)
 * @method static void                                                      singletonNullObjectProxy(string $className)
 * @method static void                                                      bindNullObjectProxy(string $className, bool $shared = false)
 * @method static void                                                      singletonRemoteObjectProxy(string $className, ?\ProxyManager\Factory\RemoteObject\AdapterInterface $adapter = null)
 * @method static void                                                      bindRemoteObjectProxy(string $className, ?\ProxyManager\Factory\RemoteObject\AdapterInterface $adapter = null, bool $shared = false)
 * @method static void                                                      extendToAccessInterceptorScopeLocalizerProxy(string $abstract, array $prefixInterceptors = [], array $suffixInterceptors = [])
 * @method static void                                                      extendToAccessInterceptorValueHolderProxy(string $abstract, array $prefixInterceptors = [], array $suffixInterceptors = [])
 * @method static void                                                      extendToLazyLoadingGhostFactoryProxy(string $abstract, \Closure $initializer, array $proxyOptions = [])
 * @method static void                                                      extendToLazyLoadingValueHolderProxy(string $abstract, \Closure $initializer, array $proxyOptions = [])
 * @method static void                                                      extendToNullObjectProxy(string $abstract)
 * @method static void                                                      extendToRemoteObjectProxy(string $abstract, ?\ProxyManager\Factory\RemoteObject\AdapterInterface $adapter = null)
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
