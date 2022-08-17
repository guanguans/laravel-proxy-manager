<?php

/**
 * This file is part of the guanguans/laravel-proxy-manager.
 *
 * (c) guanguans <ityaozm@gmail.com>
 *
 * This source file is subject to the MIT license that is bundled.
 */

use Guanguans\LaravelProxyManager\Facades\LazyLoadingValueHolderFactory;
use SebastianBergmann\Timer\Timer;

it('The return value is the same as the return value of the source class method.', function () {
    class Foo
    {
        public function __construct()
        {
        }

        public function doFoo(): string
        {
            return 'Foo';
        }
    }

    $proxy = LazyLoadingValueHolderFactory::createProxy(
            Foo::class,
            function (?object &$wrappedObject, ?object $proxy, string $method, array $parameters, ?Closure &$initializer) {
                $initializer = null;
                $wrappedObject = new Foo();

                return true;
            }
        );

    expect($proxy->doFoo())->toEqual((new Foo())->doFoo());
});

it('The class is actually initialized when the proxy class calls the method', function () {
    class Bar
    {
        public function __construct()
        {
            sleep(1);
        }

        public function doBar(): string
        {
            return 'Bar';
        }
    }

    $timer = new Timer();
    $timer->start();
    $timer->start();

    $proxy = LazyLoadingValueHolderFactory::createProxy(
        Bar::class,
        function (?object &$wrappedObject, ?object $proxy, string $method, array $parameters, ?Closure &$initializer) {
            $initializer = null;
            $wrappedObject = new Bar();

            return true;
        }
    );

    expect($timer->stop()->asSeconds())->toBeLessThan(1);
    $proxy->doBar();
    expect($timer->stop()->asSeconds())->toBeGreaterThan(1);
});
