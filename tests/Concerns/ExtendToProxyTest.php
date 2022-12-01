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
use Guanguans\LaravelProxyManagerTests\TestClasses\AccessInterceptorScopeLocalizerTestClass;
use Guanguans\LaravelProxyManagerTests\TestClasses\AccessInterceptorValueHolderTestClass;
use Guanguans\LaravelProxyManagerTests\TestClasses\LazyLoadingGhostTestClass;
use Guanguans\LaravelProxyManagerTests\TestClasses\LocalBookObjectTestClass;
use Guanguans\LaravelProxyManagerTests\TestClasses\NullObjectTestClass;
use Guanguans\LaravelProxyManagerTests\TestClasses\RemoteNullObjectAdapterTestClass;
use Guanguans\LaravelProxyManagerTests\TestClasses\ValueHolderTestClass;
use ProxyManager\Proxy\AccessInterceptorInterface;
use ProxyManager\Proxy\AccessInterceptorValueHolderInterface;
use ProxyManager\Proxy\GhostObjectInterface;
use ProxyManager\Proxy\RemoteObjectInterface;
use ProxyManager\Proxy\ValueHolderInterface;

it('will not return for `extendToAccessInterceptorScopeLocalizerProxy`', function (): void {
    expect(app(ProxyManager::class))
        ->extendToAccessInterceptorScopeLocalizerProxy(
            AccessInterceptorScopeLocalizerTestClass::class,
            [
                'fluentMethod' => static function (AccessInterceptorInterface $proxy, AccessInterceptorScopeLocalizerTestClass $realInstance) {
                    echo "before-fluentMethod: #$realInstance->counter\n";
                },
            ],
            [
                'fluentMethod' => static function (AccessInterceptorInterface $proxy, AccessInterceptorScopeLocalizerTestClass $realInstance) {
                    echo "after-fluentMethod: #$realInstance->counter\n";
                },
            ]
        )
        ->toBeNull()
        ->and(app(AccessInterceptorScopeLocalizerTestClass::class))
        ->toBeInstanceOf(AccessInterceptorScopeLocalizerTestClass::class)
        ->toBeInstanceOf(AccessInterceptorInterface::class);
});

it('will not return for `extendToAccessInterceptorValueHolderProxy`', function (): void {
    expect(app(ProxyManager::class))
        ->extendToAccessInterceptorValueHolderProxy(
            AccessInterceptorValueHolderTestClass::class,
            [
                'execute' => function () {
                    echo "before-execute\n";
                },
            ],
            [
                'execute' => function () {
                    echo 'after-execute';
                },
            ]
        )
        ->toBeNull()
        ->and(app(AccessInterceptorValueHolderTestClass::class))
        ->toBeInstanceOf(AccessInterceptorValueHolderTestClass::class)
        ->toBeInstanceOf(AccessInterceptorValueHolderInterface::class);
});

it('will not return for `extendToLazyLoadingGhostFactoryProxy`', function (): void {
    expect(app(ProxyManager::class))
        ->extendToLazyLoadingGhostFactoryProxy(
            LazyLoadingGhostTestClass::class,
            function (GhostObjectInterface $proxy, string $method, array $parameters, &$initializer, array $properties) {
                $initializer = null;
                $properties["\0Guanguans\\LaravelProxyManagerTests\\TestClasses\\LazyLoadingGhostTestClass\0id"] = 1;
                $properties["\0Guanguans\\LaravelProxyManagerTests\\TestClasses\\LazyLoadingGhostTestClass\0name"] = 'name';

                return true;
            },
            [
                'skippedProperties' => [
                    "\0Guanguans\\LaravelProxyManagerTests\\TestClasses\\LazyLoadingGhostTestClass\0id",
                ],
            ]
        )
        ->toBeNull()
        ->and(app(LazyLoadingGhostTestClass::class))
        ->toBeInstanceOf(LazyLoadingGhostTestClass::class)
        ->toBeInstanceOf(GhostObjectInterface::class);
});

it('will not return for `extendToLazyLoadingValueHolderProxy`', function (): void {
    expect(app(ProxyManager::class))
        ->extendToLazyLoadingValueHolderProxy(
            ValueHolderTestClass::class,
            function (?object &$wrappedObject, ?object $proxy, string $method, array $parameters, ?\Closure &$initializer) {
                $initializer = null;
                $wrappedObject = new ValueHolderTestClass();

                return true;
            },
            []
        )
        ->toBeNull()
        ->and(app(ValueHolderTestClass::class))
        ->toBeInstanceOf(ValueHolderTestClass::class)
        ->toBeInstanceOf(ValueHolderInterface::class);
});

it('will not return for `extendToNullObjectProxy`', function (): void {
    expect(app(ProxyManager::class))
        ->extendToNullObjectProxy(NullObjectTestClass::class)
        ->toBeNull()
        ->and(app(NullObjectTestClass::class))
        ->toBeInstanceOf(NullObjectTestClass::class)
        ->getId()
        ->toBeNull();
})->throws(\TypeError::class);

it('will not return for `extendToRemoteObjectProxy`', function (): void {
    expect(app(ProxyManager::class))
        ->extendToRemoteObjectProxy(LocalBookObjectTestClass::class, new RemoteNullObjectAdapterTestClass())
        ->toBeNull()
        ->and(app(LocalBookObjectTestClass::class))
        ->toBeInstanceOf(LocalBookObjectTestClass::class)
        ->toBeInstanceOf(RemoteObjectInterface::class);
});
