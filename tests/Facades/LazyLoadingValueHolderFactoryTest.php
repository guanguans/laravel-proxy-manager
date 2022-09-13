<?php

/**
 * This file is part of the guanguans/laravel-proxy-manager.
 *
 * (c) guanguans <ityaozm@gmail.com>
 *
 * This source file is subject to the MIT license that is bundled.
 */

namespace Guanguans\LaravelProxyManagerTests\Facades;

use Closure;
use Guanguans\LaravelProxyManager\Facades\LazyLoadingValueHolderFactory;
use Guanguans\LaravelProxyManagerTests\TestClasses\LazyLoadingValueHolderTestClass;
use Guanguans\LaravelProxyManagerTests\TestClasses\ValueHolderTestClass;
use ProxyManager\Proxy\VirtualProxyInterface;
use SebastianBergmann\Timer\Timer;

it('will return `LazyLoadingValueHolder` proxy', function (): void {
    $proxy = LazyLoadingValueHolderFactory::createProxy(
        ValueHolderTestClass::class,
        function (?object &$wrappedObject, ?VirtualProxyInterface $virtualProxy, string $method, array $parameters, ?Closure &$initializer): bool {
            $initializer = null;
            $wrappedObject = new ValueHolderTestClass();

            return true;
        }
    );

    expect($proxy)
        ->toBeInstanceOf(ValueHolderTestClass::class)
        ->toBeInstanceOf(VirtualProxyInterface::class);
});

it('will actually initialized when the proxy class calls the method', function (): void {
    $timer = new Timer();
    $timer->start();
    $timer->start();
    $timer->start();

    $sleepMicroseconds = 100000;
    $proxy = LazyLoadingValueHolderFactory::createProxy(
        LazyLoadingValueHolderTestClass::class,
        function (?object &$wrappedObject, ?VirtualProxyInterface $virtualProxy, string $method, array $parameters, ?Closure &$initializer) use ($sleepMicroseconds): bool {
            $initializer = null;
            $wrappedObject = new LazyLoadingValueHolderTestClass($sleepMicroseconds);

            return true;
        }
    );
    expect($timer->stop()->asMicroseconds())->toBeLessThan($sleepMicroseconds);

    $proxy->execute();
    expect($timer->stop()->asMicroseconds())->toBeGreaterThan($sleepMicroseconds);

    $proxy->execute();
    expect($timer->stop()->asMicroseconds())->between($sleepMicroseconds, 2 * $sleepMicroseconds);
});
