<?php

/**
 * This file is part of the guanguans/laravel-proxy-manager.
 *
 * (c) guanguans <ityaozm@gmail.com>
 *
 * This source file is subject to the MIT license that is bundled.
 */

namespace Guanguans\LaravelProxyManagerTests\Facades;

use Guanguans\LaravelProxyManager\Facades\AccessInterceptorValueHolderFactory;
use Guanguans\LaravelProxyManagerTests\TestClasses\AccessInterceptorValueHolderTestClass;
use ProxyManager\Proxy\AccessInterceptorValueHolderInterface;

beforeEach(function () {
    ob_get_contents() and ob_clean() and ob_start();
});

afterEach(function () {
    ob_clean();
});

it('will return `AccessInterceptorValueHolder` proxy', function () {
    $proxy = AccessInterceptorValueHolderFactory::createProxy(
        new AccessInterceptorValueHolderTestClass(),
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
    );

    expect($proxy)
        ->toBeInstanceOf(AccessInterceptorValueHolderTestClass::class)
        ->toBeInstanceOf(AccessInterceptorValueHolderInterface::class)
        ->execute()
        ->and(ob_get_contents())
        ->toBe("before-execute\nafter-execute");
});
