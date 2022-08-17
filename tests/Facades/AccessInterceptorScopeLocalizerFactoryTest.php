<?php

/**
 * This file is part of the guanguans/laravel-proxy-manager.
 *
 * (c) guanguans <ityaozm@gmail.com>
 *
 * This source file is subject to the MIT license that is bundled.
 */

use Guanguans\LaravelProxyManager\Facades\AccessInterceptorScopeLocalizerFactory;
use Guanguans\LaravelProxyManagerTests\TestClasses\AccessInterceptorScopeLocalizerTestClass;
use ProxyManager\Proxy\AccessInterceptorInterface;

beforeEach(function () {
    ob_get_contents() and ob_clean() and ob_start();
});

afterEach(function () {
    ob_clean();
});

it("An access interceptor scope localizer is a smart reference proxy that allows you to dynamically define logic to be executed before or after any of the proxied object methods' logic.", function () {
    $accessInterceptorScopeLocalizer = new AccessInterceptorScopeLocalizerTestClass();

    $proxy = AccessInterceptorScopeLocalizerFactory::createProxy(
        $accessInterceptorScopeLocalizer,
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

    $proxy->fluentMethod()->fluentMethod()->fluentMethod();

    expect($proxy->counter)
        ->toEqual($accessInterceptorScopeLocalizer->counter)
        ->toEqual(3);

    expect(ob_get_contents())
        ->toEqual("before-fluentMethod: #0\nafter-fluentMethod: #1\nbefore-fluentMethod: #1\nafter-fluentMethod: #2\nbefore-fluentMethod: #2\nafter-fluentMethod: #3\n");
});
