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
use SebastianBergmann\Timer\Timer;

it('the return value is the same as the return value of the source class method', function () {
    $proxy = LazyLoadingValueHolderFactory::createProxy(
        ValueHolderTestClass::class,
        function (?object &$wrappedObject, ?object $proxy, string $method, array $parameters, ?Closure &$initializer) {
            $initializer = null;
            $wrappedObject = new ValueHolderTestClass();

            return true;
        }
    );

    expect($proxy->execute())->toEqual((new ValueHolderTestClass())->execute());
});

it('the class is actually initialized when the proxy class calls the method', function () {
    $timer = new Timer();
    $timer->start();
    $timer->start();
    $timer->start();

    $sleepSeconds = 1;
    $proxy = LazyLoadingValueHolderFactory::createProxy(
        LazyLoadingValueHolderTestClass::class,
        function (?object &$wrappedObject, ?object $proxy, string $method, array $parameters, ?Closure &$initializer) use ($sleepSeconds) {
            $initializer = null;
            $wrappedObject = new LazyLoadingValueHolderTestClass($sleepSeconds);

            return true;
        }
    );

    expect($timer->stop()->asSeconds())->toBeLessThan($sleepSeconds);
    $proxy->execute();
    expect($timer->stop()->asSeconds())->toBeGreaterThan($sleepSeconds);
    $proxy->execute();
    expect($timer->stop()->asSeconds())->toBeGreaterThan($sleepSeconds)->toBeLessThan(2 * $sleepSeconds);
});
