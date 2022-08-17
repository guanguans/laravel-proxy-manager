<?php

/**
 * This file is part of the guanguans/laravel-proxy-manager.
 *
 * (c) guanguans <ityaozm@gmail.com>
 *
 * This source file is subject to the MIT license that is bundled.
 */

use Guanguans\LaravelProxyManager\Facades\NullObjectFactory;
use Guanguans\LaravelProxyManagerTests\TestClasses\NullObjectTestClass;

it('Should return a proxy empty instance.', function () {
    $proxy = NullObjectFactory::createProxy(NullObjectTestClass::class);
    expect($proxy)
        ->toBeInstanceOf(NullObjectTestClass::class)
        ->and($proxy->getId())
        ->toBeNull();

    $proxy = NullObjectFactory::createProxy(new NullObjectTestClass(1));
    expect($proxy)
        ->toBeInstanceOf(NullObjectTestClass::class)
        ->and($proxy->getId())
        ->toBeNull();
});
