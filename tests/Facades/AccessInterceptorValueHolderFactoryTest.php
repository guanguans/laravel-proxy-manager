<?php

/**
 * This file is part of the guanguans/laravel-proxy-manager.
 *
 * (c) guanguans <ityaozm@gmail.com>
 *
 * This source file is subject to the MIT license that is bundled.
 */

use Guanguans\LaravelProxyManager\Facades\AccessInterceptorValueHolderFactory;
use Guanguans\LaravelProxyManagerTests\TestClasses\AccessInterceptorValueHolderTestClass;

beforeEach(function () {
    ob_get_contents() and ob_clean() and ob_start();
});

afterEach(function () {
    ob_clean();
});

it('Add pre-execution and post-execution behavior to a method.', function () {
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

    $proxy->execute();

    expect(ob_get_contents())->toEqual("before-execute\nafter-execute");
});
