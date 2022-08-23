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

it('will return `LazyLoadingGhost` proxy', function () {
    $id = 1;
    $name = 'name';

    $proxy = LazyLoadingGhostFactory::createProxy(
        LazyLoadingGhostTestClass::class,
        function (GhostObjectInterface $proxy, string $method, array $parameters, &$initializer, array $properties) use ($id, $name) {
            $initializer = null;
            $properties["\0Guanguans\\LaravelProxyManagerTests\\TestClasses\\LazyLoadingGhostTestClass\0id"] = $id;
            $properties["\0Guanguans\\LaravelProxyManagerTests\\TestClasses\\LazyLoadingGhostTestClass\0name"] = $name;
            dump('Triggered lazy loading.');

            return true;
        },
        [
            'skippedProperties' => [
                "\0Guanguans\\LaravelProxyManagerTests\\TestClasses\\LazyLoadingGhostTestClass\0id",
            ],
        ]
    );

    expect($proxy)
        ->toBeInstanceOf(LazyLoadingGhostTestClass::class)
        ->toBeInstanceOf(GhostObjectInterface::class)
        ->getName() // Triggered lazy loading.'
        ->toBe($name)
        ->getId()
        ->toBeNull();
});
