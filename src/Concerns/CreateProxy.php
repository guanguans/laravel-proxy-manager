<?php

/**
 * This file is part of the guanguans/laravel-proxy-manager.
 *
 * (c) guanguans <ityaozm@gmail.com>
 *
 * This source file is subject to the MIT license that is bundled.
 */

namespace Guanguans\LaravelProxyManager\Concerns;

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
use ProxyManager\Proxy\ValueHolderInterface;
use ProxyManager\Proxy\VirtualProxyInterface;
use ProxyManager\Signature\Exception\InvalidSignatureException;
use ProxyManager\Signature\Exception\MissingSignatureException;

trait CreateProxy
{
    /**
     * @psalm-suppress InvalidReturnType
     *
     * @param object                  $instance           the object to be localized within the access interceptor
     * @param array<string, \Closure> $prefixInterceptors an array (indexed by method name) of interceptor closures to be called
     *                                                    before method logic is executed
     * @param array<string, \Closure> $suffixInterceptors an array (indexed by method name) of interceptor closures to be called
     *                                                    after method logic is executed
     *
     * @psalm-template RealObjectType of object
     *
     * @psalm-param RealObjectType $instance
     * @psalm-param array<string, Closure(
     *   RealObjectType&AccessInterceptorInterface<RealObjectType>=,
     *   RealObjectType=,
     *   string=,
     *   array<string, mixed>=,
     *   bool=
     * ) : mixed> $prefixInterceptors
     * @psalm-param array<string, Closure(
     *   RealObjectType&AccessInterceptorInterface<RealObjectType>=,
     *   RealObjectType=,
     *   string=,
     *   array<string, mixed>=,
     *   mixed=,
     *   bool=
     * ) : mixed> $suffixInterceptors
     *
     * @psalm-return RealObjectType&AccessInterceptorInterface<RealObjectType>
     *
     * @throws InvalidSignatureException
     * @throws MissingSignatureException
     * @throws \OutOfBoundsException
     *
     * @psalm-suppress MixedInferredReturnType We ignore type checks here, since `staticProxyConstructor` is not
     *                                         interfaced (by design)
     */
    public function createAccessInterceptorScopeLocalizerProxy(object $instance, array $prefixInterceptors = [], array $suffixInterceptors = []): AccessInterceptorInterface
    {
        return AccessInterceptorScopeLocalizerFactory::createProxy($instance, $prefixInterceptors, $suffixInterceptors);
    }

    /**
     * @psalm-suppress InvalidReturnType
     *
     * @param object                  $instance           the object to be wrapped within the value holder
     * @param array<string, \Closure> $prefixInterceptors an array (indexed by method name) of interceptor closures to be called
     *                                                    before method logic is executed
     * @param array<string, \Closure> $suffixInterceptors an array (indexed by method name) of interceptor closures to be called
     *                                                    after method logic is executed
     *
     * @psalm-template RealObjectType of object
     *
     * @psalm-param RealObjectType $instance
     * @psalm-param array<string, callable(
     *   RealObjectType&AccessInterceptorInterface<RealObjectType>=,
     *   RealObjectType=,
     *   string=,
     *   array<string, mixed>=,
     *   bool=
     * ) : mixed> $prefixInterceptors
     * @psalm-param array<string, callable(
     *   RealObjectType&AccessInterceptorInterface<RealObjectType>=,
     *   RealObjectType=,
     *   string=,
     *   array<string, mixed>=,
     *   mixed=,
     *   bool=
     * ) : mixed> $suffixInterceptors
     *
     * @psalm-return RealObjectType&AccessInterceptorInterface<RealObjectType>&ValueHolderInterface<RealObjectType>&AccessInterceptorValueHolderInterface<RealObjectType>
     *
     * @throws InvalidSignatureException
     * @throws MissingSignatureException
     * @throws \OutOfBoundsException
     *
     * @psalm-suppress MixedInferredReturnType We ignore type checks here, since `staticProxyConstructor` is not
     *                                         interfaced (by design)
     */
    public function createAccessInterceptorValueHolderProxy(object $instance, array $prefixInterceptors = [], array $suffixInterceptors = []): AccessInterceptorValueHolderInterface
    {
        return AccessInterceptorValueHolderFactory::createProxy($instance, $prefixInterceptors, $suffixInterceptors);
    }

    /**
     * @psalm-suppress InvalidReturnType
     * Creates a new lazy proxy instance of the given class with
     * the given initializer.
     *
     * Please refer to the following documentation when using this method:
     *
     * @see https://github.com/Ocramius/ProxyManager/blob/master/docs/lazy-loading-ghost-object.md
     *
     * @param string   $className   name of the class to be proxied
     * @param \Closure $initializer initializer to be passed to the proxy. The initializer closure should have following
     *                              signature:
     *
     *                              <code>
     *                              $initializer = function (
     *                                  GhostObjectInterface $proxy,
     *                                  string $method,
     *                                  array $parameters,
     *                                  & $initializer,
     *                                  array $properties
     *                              ) {};
     *                              </code>
     *
     *                              Where:
     *                               - $proxy is the proxy instance on which the initializer is acting
     *                               - $method is the name of the method that triggered the lazy initialization
     *                               - $parameters are the parameters that were passed to $method
     *                               - $initializer by-ref initializer - should be assigned null in the initializer body
     *                               - $properties a by-ref map of the properties of the object, indexed by PHP
     *                                             internal property name. Assign values to it to initialize the
     *                                             object state
     * @param mixed[] $proxyOptions a set of options to be used when generating the proxy. Currently supports only
     *                              key "skippedProperties", which allows to skip lazy-loading of some properties.
     *                              "skippedProperties" is a string[], containing a list of properties referenced
     *                              via PHP's internal property name (i.e. "\0ClassName\0propertyName")
     *
     * @psalm-template RealObjectType as object
     *
     * @psalm-param class-string<RealObjectType> $className
     * @psalm-param Closure(
     *   RealObjectType&GhostObjectInterface<RealObjectType>=,
     *   string=,
     *   array<string, mixed>=,
     *   ?Closure=,
     *   array<string, mixed>=
     * ) : bool $initializer
     * @psalm-param array{skippedProperties?: array<int, string>} $proxyOptions
     *
     * @psalm-return RealObjectType&GhostObjectInterface<RealObjectType>
     *
     * @throws MissingSignatureException
     * @throws InvalidSignatureException
     * @throws \OutOfBoundsException
     *
     * @psalm-suppress MixedInferredReturnType We ignore type checks here, since `staticProxyConstructor` is not
     *                                         interfaced (by design)
     */
    public function createLazyLoadingGhostFactoryProxy(string $className, \Closure $initializer, array $proxyOptions = []): GhostObjectInterface
    {
        return LazyLoadingGhostFactory::createProxy($className, $initializer, $proxyOptions);
    }

    /**
     * @psalm-suppress InvalidReturnType
     *
     * @param array<string, mixed> $proxyOptions
     *
     * @psalm-template RealObjectType of object
     *
     * @psalm-param class-string<RealObjectType> $className
     * @psalm-param Closure(
     *   RealObjectType|null=,
     *   RealObjectType&ValueHolderInterface<RealObjectType>&VirtualProxyInterface=,
     *   string=,
     *   array<string, mixed>=,
     *   ?Closure=
     * ) : bool $initializer
     *
     * @psalm-return RealObjectType&ValueHolderInterface<RealObjectType>&VirtualProxyInterface
     *
     * @psalm-suppress MixedInferredReturnType We ignore type checks here, since `staticProxyConstructor` is not
     *                                         interfaced (by design)
     */
    public function createLazyLoadingValueHolderProxy(string $className, \Closure $initializer, array $proxyOptions = []): VirtualProxyInterface
    {
        return LazyLoadingValueHolderFactory::createProxy($className, $initializer, $proxyOptions);
    }

    /**
     * @psalm-suppress InvalidReturnType
     *
     * @param object|string $instanceOrClassName the object to be wrapped or interface to transform to null object
     *
     * @psalm-template RealObjectType of object
     *
     * @psalm-param RealObjectType|class-string<RealObjectType> $instanceOrClassName
     *
     * @psalm-return RealObjectType&NullObjectInterface
     *
     * @throws InvalidSignatureException
     * @throws MissingSignatureException
     * @throws \OutOfBoundsException
     *
     * @psalm-suppress MixedInferredReturnType We ignore type checks here, since `staticProxyConstructor` is not
     *                                         interfaced (by design)
     */
    public function createNullObjectProxy($instanceOrClassName): NullObjectInterface
    {
        return NullObjectFactory::createProxy($instanceOrClassName);
    }

    /**
     * @psalm-suppress InvalidReturnType
     *
     * @param string|object $instanceOrClassName
     *
     * @psalm-template RealObjectType of object
     *
     * @psalm-param RealObjectType|class-string<RealObjectType> $instanceOrClassName
     *
     * @psalm-return RealObjectType&RemoteObjectInterface
     *
     * @throws InvalidSignatureException
     * @throws MissingSignatureException
     * @throws \OutOfBoundsException
     * @throws \RuntimeException
     *
     * @psalm-suppress MixedInferredReturnType We ignore type checks here, since `staticProxyConstructor` is not
     *                                         interfaced (by design)
     */
    public function createRemoteObjectProxy($instanceOrClassName, ?AdapterInterface $adapter = null): RemoteObjectInterface
    {
        return RemoteObjectFactory::createProxy($instanceOrClassName, $adapter);
    }
}
