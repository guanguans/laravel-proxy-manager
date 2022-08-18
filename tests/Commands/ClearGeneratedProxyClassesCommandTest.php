<?php

/**
 * This file is part of the guanguans/laravel-proxy-manager.
 *
 * (c) guanguans <ityaozm@gmail.com>
 *
 * This source file is subject to the MIT license that is bundled.
 */

use Guanguans\LaravelProxyManager\Commands\ClearGeneratedProxyClassesCommand;

use function Pest\Laravel\artisan;

it('thrown no exceptions with proxy classes deleted', function () {
    artisan(ClearGeneratedProxyClassesCommand::class)->assertSuccessful();
});
