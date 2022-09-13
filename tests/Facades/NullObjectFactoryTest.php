<?php

/**
 * This file is part of the guanguans/laravel-proxy-manager.
 *
 * (c) guanguans <ityaozm@gmail.com>
 *
 * This source file is subject to the MIT license that is bundled.
 */

namespace Guanguans\LaravelProxyManagerTests\Facades;

use Guanguans\LaravelProxyManager\Facades\NullObjectFactory;
use Guanguans\LaravelProxyManagerTests\TestClasses\NullObjectTestClass;
use ProxyManager\Proxy\NullObjectInterface;
use TypeError;

it('will return `NullObject` proxy', function (): void {
    $proxy = NullObjectFactory::createProxy(NullObjectTestClass::class);
    expect($proxy)
        ->toBeInstanceOf(NullObjectTestClass::class)
        ->toBeInstanceOf(NullObjectInterface::class);

    $proxy = NullObjectFactory::createProxy(new NullObjectTestClass(1));
    expect($proxy)
        ->toBeInstanceOf(NullObjectTestClass::class)
        ->toBeInstanceOf(NullObjectInterface::class);
});

it('will throw TypeError', function (): void {
    $proxy = NullObjectFactory::createProxy(new NullObjectTestClass(1));
    expect($proxy)
        ->and($proxy->getId())
        ->toBeNull();
})->throws(TypeError::class);
