<?php

/**
 * This file is part of the guanguans/laravel-proxy-manager.
 *
 * (c) guanguans <ityaozm@gmail.com>
 *
 * This source file is subject to the MIT license that is bundled.
 */

namespace Guanguans\LaravelProxyManagerTests\Facades;

use Guanguans\LaravelProxyManager\Facades\AccessInterceptorScopeLocalizerFactory;
use Guanguans\LaravelProxyManagerTests\TestClasses\AccessInterceptorScopeLocalizerTestClass;
use ProxyManager\Proxy\AccessInterceptorInterface;

beforeEach(function () {
    ob_get_contents() and ob_clean() and ob_start();
});

afterEach(function () {
    ob_clean();
});

it('will return `AccessInterceptorScopeLocalizer` proxy', function () {
    $proxy = AccessInterceptorScopeLocalizerFactory::createProxy(
        $accessInterceptorScopeLocalizer = new AccessInterceptorScopeLocalizerTestClass(),
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
    );

    expect($proxy)
        ->toBeInstanceOf(AccessInterceptorScopeLocalizerTestClass::class)
        ->toBeInstanceOf(AccessInterceptorInterface::class)
        ->fluentMethod()->fluentMethod()
        ->and($proxy->counter)
        ->toBe($accessInterceptorScopeLocalizer->counter)
        ->toBe(2)
        ->and(ob_get_contents())
        ->toBe("before-fluentMethod: #0\nafter-fluentMethod: #1\nbefore-fluentMethod: #1\nafter-fluentMethod: #2\n");
});
