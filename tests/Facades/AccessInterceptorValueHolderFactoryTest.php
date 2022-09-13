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

beforeEach(function (): void {
    ob_get_contents() and ob_clean() and ob_start();
});

afterEach(function (): void {
    ob_clean();
});

it('will return `AccessInterceptorValueHolder` proxy', function (): void {
    $accessInterceptorValueHolder = AccessInterceptorValueHolderFactory::createProxy(
        new AccessInterceptorValueHolderTestClass(),
        [
            'execute' => function (): void {
                echo "before-execute\n";
            },
        ],
        [
            'execute' => function (): void {
                echo 'after-execute';
            },
        ]
    );

    expect($accessInterceptorValueHolder)
        ->toBeInstanceOf(AccessInterceptorValueHolderTestClass::class)
        ->toBeInstanceOf(AccessInterceptorValueHolderInterface::class)
        ->execute()
        ->and(ob_get_contents())
        ->toBe("before-execute\nafter-execute");
});
