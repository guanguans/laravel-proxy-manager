<?php

/**
 * This file is part of the guanguans/laravel-proxy-manager.
 *
 * (c) guanguans <ityaozm@gmail.com>
 *
 * This source file is subject to the MIT license that is bundled.
 */

namespace Guanguans\LaravelProxyManagerTests\Facades;

use Guanguans\LaravelProxyManager\Facades\LazyLoadingGhostFactory;
use Guanguans\LaravelProxyManagerTests\TestClasses\LazyLoadingGhostTestClass;
use ProxyManager\Proxy\GhostObjectInterface;

it("the property doesn't actually exist until the ghost object is initialized", function () {
    $id = 1;
    $name = 'name';

    $proxy = LazyLoadingGhostFactory::createProxy(
        LazyLoadingGhostTestClass::class,
        function (GhostObjectInterface $proxy, string $method, array $parameters, &$initializer, array $properties) use ($id, $name) {
            $initializer = null;
            dump('Triggered lazy-loading');
            $properties["\0Guanguans\\LaravelProxyManagerTests\\TestClasses\\LazyLoadingGhostTestClass\0id"] = $id;
            $properties["\0Guanguans\\LaravelProxyManagerTests\\TestClasses\\LazyLoadingGhostTestClass\0name"] = $name;

            return true;
        },
        [
            'skippedProperties' => [
                "\0Guanguans\\LaravelProxyManagerTests\\TestClasses\\LazyLoadingGhostTestClass\0id",
            ],
        ]
    );

    expect($proxy->getId())->toBeNull();
    expect($proxy->getName())->toEqual($name);
});
