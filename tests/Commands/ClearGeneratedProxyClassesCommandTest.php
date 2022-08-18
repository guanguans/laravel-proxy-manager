<?php

/**
 * This file is part of the guanguans/laravel-proxy-manager.
 *
 * (c) guanguans <ityaozm@gmail.com>
 *
 * This source file is subject to the MIT license that is bundled.
 */

use Guanguans\LaravelProxyManager\Commands\ClearGeneratedProxyClassesCommand;

it('thrown no exceptions with proxy classes deleted', function () {
    \Pest\Laravel\artisan(ClearGeneratedProxyClassesCommand::class)->assertSuccessful();
});
