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
use InvalidArgumentException;
use ProxyManager\Factory\RemoteObject\AdapterInterface;
use ProxyManager\Proxy\VirtualProxyInterface;

trait BindProxy
{
    public function singletonLazyLoadingValueHolderProxy(string $className, ?Closure $concrete = null): void
    {
        $this->bindLazyLoadingValueHolderProxy($className, $concrete);
    }

    public function bindLazyLoadingValueHolderProxy(string $className, ?Closure $concrete = null, bool $shared = false): void
    {
        if (! class_exists($className)) {
            throw new InvalidArgumentException("Target class [$className] does not exist.");
        }

        if (is_null($concrete)) {
            $concrete = function ($container, $parameters = []) use ($className) {
                return $this->container->build($className);
            };
        }

        $initializer = function (?object &$wrappedObject, VirtualProxyInterface $virtualProxy, string $method, array $parameters, ?Closure &$initializer) use ($concrete) {
            $initializer = null;
            $wrappedObject = $concrete($this->container, []);

            return true;
        };

        $this->container->bind(
            $className,
            function ($container, $parameters = []) use ($className, $initializer) {
                return $this->createLazyLoadingValueHolderProxy($className, $initializer);
            },
            $shared
        );
    }

    public function singletonNullObjectProxy(string $className): void
    {
        $this->bindNullObjectProxy($className, true);
    }

    public function bindNullObjectProxy(string $className, bool $shared = false): void
    {
        if (! class_exists($className)) {
            throw new InvalidArgumentException("Target class [$className] does not exist.");
        }

        $this->container->bind(
            $className,
            function ($container, $parameters = []) use ($className) {
                return $this->createNullObjectProxy($className);
            },
            $shared
        );
    }

    public function singletonRemoteObjectProxy(string $className, ?AdapterInterface $adapter = null): void
    {
        $this->bindRemoteObjectProxy($className, $adapter, true);
    }

    public function bindRemoteObjectProxy(string $className, ?AdapterInterface $adapter = null, bool $shared = false): void
    {
        if (! class_exists($className)) {
            throw new InvalidArgumentException("Target class [$className] does not exist.");
        }

        $this->container->bind(
            $className,
            function ($container, $parameters = []) use ($className, $adapter) {
                return $this->createRemoteObjectProxy($className, $adapter);
            },
            $shared
        );
    }
}
