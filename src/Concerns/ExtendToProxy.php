<?php

/**
 * This file is part of the guanguans/laravel-proxy-manager.
 *
 * (c) guanguans <ityaozm@gmail.com>
 *
 * This source file is subject to the MIT license that is bundled.
 */

namespace Guanguans\LaravelProxyManager\Concerns;

use Illuminate\Container\Container;
use ProxyManager\Factory\RemoteObject\AdapterInterface;

trait ExtendToProxy
{
    public function extendToAccessInterceptorScopeLocalizerProxy(string $abstract, array $prefixInterceptors = [], array $suffixInterceptors = []): void
    {
        $this->container->extend(
            $abstract,
            fn (object $instance, Container $container) => $this->createAccessInterceptorScopeLocalizerProxy($instance, $prefixInterceptors, $suffixInterceptors)
        );
    }

    public function extendToAccessInterceptorValueHolderProxy(string $abstract, array $prefixInterceptors = [], array $suffixInterceptors = []): void
    {
        $this->container->extend(
            $abstract,
            fn (object $instance, Container $container) => $this->createAccessInterceptorValueHolderProxy($instance, $prefixInterceptors, $suffixInterceptors)
        );
    }

    public function extendToLazyLoadingGhostFactoryProxy(string $abstract, \Closure $initializer, array $proxyOptions = []): void
    {
        $this->container->extend(
            $abstract,
            fn (object $instance, Container $container) => $this->createLazyLoadingGhostFactoryProxy(get_class($instance), $initializer, $proxyOptions)
        );
    }

    public function extendToLazyLoadingValueHolderProxy(string $abstract, \Closure $initializer, array $proxyOptions = []): void
    {
        $this->container->extend(
            $abstract,
            fn (object $instance, Container $container) => $this->createLazyLoadingValueHolderProxy(get_class($instance), $initializer, $proxyOptions)
        );
    }

    public function extendToNullObjectProxy(string $abstract): void
    {
        $this->container->extend(
            $abstract,
            fn (object $instance, Container $container) => $this->createNullObjectProxy($instance)
        );
    }

    public function extendToRemoteObjectProxy(string $abstract, AdapterInterface $adapter = null): void
    {
        $this->container->extend(
            $abstract,
            fn (object $instance, Container $container) => $this->createRemoteObjectProxy($instance, $adapter)
        );
    }
}
