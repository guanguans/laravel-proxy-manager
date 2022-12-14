<?php

/**
 * This file is part of the guanguans/laravel-proxy-manager.
 *
 * (c) guanguans <ityaozm@gmail.com>
 *
 * This source file is subject to the MIT license that is bundled.
 */

namespace Guanguans\LaravelProxyManagerTests\Commands;

use Guanguans\LaravelProxyManager\Commands\ClearGeneratedProxyClassesCommand;
use Illuminate\Support\Str;

use function Pest\Laravel\artisan;

it('will output `Proxy classes directory not found.`', function (): void {
    config([
        'proxy-manager.generated_proxies_dir' => __DIR__.DIRECTORY_SEPARATOR
                                                 .'..'.DIRECTORY_SEPARATOR
                                                 .Str::random().DIRECTORY_SEPARATOR,
    ]);

    artisan(ClearGeneratedProxyClassesCommand::class)
        ->expectsOutput('Proxy classes directory not found.')
        ->assertSuccessful();
});

it('will clear successfully', function (): void {
    config([
        'proxy-manager.generated_proxies_dir' => __DIR__.DIRECTORY_SEPARATOR
                                                 .'..'.DIRECTORY_SEPARATOR
                                                 .'stub'.DIRECTORY_SEPARATOR
                                                 .'proxies',
    ]);

    artisan(ClearGeneratedProxyClassesCommand::class)
        ->expectsOutput('Clearing generated proxy classes...')
        ->expectsOutput('Generated proxy classes have been cleared')
        ->assertSuccessful();
});
