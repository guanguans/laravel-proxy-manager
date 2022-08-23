<?php

/**
 * This file is part of the guanguans/laravel-proxy-manager.
 *
 * (c) guanguans <ityaozm@gmail.com>
 *
 * This source file is subject to the MIT license that is bundled.
 */

namespace Guanguans\LaravelProxyManager\Factories;

use Guanguans\LaravelProxyManagerTests\TestClasses\AbstractLocalObjectTestClass;
use Nyholm\NSA;
use ProxyManager\ProxyGenerator\ProxyGeneratorInterface;
use RuntimeException;

it('will return instance of `ProxyGeneratorInterface`', function () {
    expect(NSA::invokeMethod(new RemoteObjectFactory(), 'getGenerator'))
        ->toBeInstanceOf(ProxyGeneratorInterface::class);
});

it('will throw `RuntimeException`', function () {
    expect(new RemoteObjectFactory())->createProxy(AbstractLocalObjectTestClass::class);
})->throws(RuntimeException::class, 'No adapter set');
