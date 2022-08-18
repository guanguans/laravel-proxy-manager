<?php

/**
 * This file is part of the guanguans/laravel-proxy-manager.
 *
 * (c) guanguans <ityaozm@gmail.com>
 *
 * This source file is subject to the MIT license that is bundled.
 */

use Guanguans\LaravelProxyManager\Commands\ListGeneratedProxyClassesCommand;
use Guanguans\LaravelProxyManager\Facades\NullObjectFactory;
use Guanguans\LaravelProxyManagerTests\TestClasses\NullObjectTestClass;
use Illuminate\Support\Str;

it('proxy classes directory not found', function () {
    config([
        'proxy-manager.generated_proxies_dir' => __DIR__.DIRECTORY_SEPARATOR
                                                 .'..'.DIRECTORY_SEPARATOR
                                                 .Str::random().DIRECTORY_SEPARATOR
                                                 .Str::random(),
    ]);

    \Pest\Laravel\artisan(ListGeneratedProxyClassesCommand::class)
        ->expectsOutput('Proxy classes directory not found.')
        ->assertSuccessful();
});

it('no generated proxy classes found', function () {
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

it('list generated proxy class infos', function () {
    config([
        'proxy-manager.generated_proxies_dir' => $proxiesDir = __DIR__.DIRECTORY_SEPARATOR
                                                 .'..'.DIRECTORY_SEPARATOR
                                                 .'stub'.DIRECTORY_SEPARATOR
                                                 .'proxies',
    ]);

    NullObjectFactory::createProxy(NullObjectTestClass::class)->getId();

    \Pest\Laravel\artisan(ListGeneratedProxyClassesCommand::class)
        ->expectsTable([], [])
        ->assertSuccessful();
});
