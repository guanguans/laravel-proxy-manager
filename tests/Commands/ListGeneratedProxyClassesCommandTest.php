<?php

/**
 * This file is part of the guanguans/laravel-proxy-manager.
 *
 * (c) guanguans <ityaozm@gmail.com>
 *
 * This source file is subject to the MIT license that is bundled.
 */

namespace Guanguans\LaravelProxyManagerTests\Commands;

use Guanguans\LaravelProxyManager\Commands\ListGeneratedProxyClassesCommand;
use Guanguans\LaravelProxyManager\Facades\NullObjectFactory;
use Guanguans\LaravelProxyManagerTests\TestClasses\NullObjectTestClass;
use Illuminate\Support\Str;

it('will output `Proxy classes directory not found.`', function () {
    config([
        'proxy-manager.generated_proxies_dir' => __DIR__.DIRECTORY_SEPARATOR
                                                 .'..'.DIRECTORY_SEPARATOR
                                                 .Str::random().DIRECTORY_SEPARATOR,
    ]);

    \Pest\Laravel\artisan(ListGeneratedProxyClassesCommand::class)
        ->expectsOutput('Proxy classes directory not found.')
        ->assertSuccessful();
});

it('will output `No generated proxy classes found.`', function () {
    config([
        'proxy-manager.generated_proxies_dir' => __DIR__.DIRECTORY_SEPARATOR
                                                 .'..'.DIRECTORY_SEPARATOR
                                                 .'stub'.DIRECTORY_SEPARATOR
                                                 .'proxies',
    ]);

    \Pest\Laravel\artisan(ListGeneratedProxyClassesCommand::class)
        ->expectsOutput('No generated proxy classes found.')
        ->assertSuccessful();
});

it('will output table', function () {
    config([
        'proxy-manager.generated_proxies_dir' => __DIR__.DIRECTORY_SEPARATOR
                                                 .'..'.DIRECTORY_SEPARATOR
                                                 .'stub'.DIRECTORY_SEPARATOR
                                                 .'proxies',
    ]);

    NullObjectFactory::createProxy(NullObjectTestClass::class)->getId();

    \Pest\Laravel\artisan(ListGeneratedProxyClassesCommand::class)
        ->expectsTable([], [])
        ->assertSuccessful();
});
