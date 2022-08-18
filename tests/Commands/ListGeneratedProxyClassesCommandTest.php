<?php

/**
 * This file is part of the guanguans/laravel-proxy-manager.
 *
 * (c) guanguans <ityaozm@gmail.com>
 *
 * This source file is subject to the MIT license that is bundled.
 */

use Guanguans\LaravelProxyManager\Commands\ListGeneratedProxyClassesCommand;

it('thrown no exceptions with list proxy classes', function () {
    \Pest\Laravel\artisan(ListGeneratedProxyClassesCommand::class)->assertSuccessful();
});
