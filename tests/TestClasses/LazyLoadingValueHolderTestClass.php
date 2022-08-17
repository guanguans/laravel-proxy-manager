<?php

/**
 * This file is part of the guanguans/laravel-proxy-manager.
 *
 * (c) guanguans <ityaozm@gmail.com>
 *
 * This source file is subject to the MIT license that is bundled.
 */

namespace Guanguans\LaravelProxyManagerTests\TestClasses;

class LazyLoadingValueHolderTestClass extends ValueHolderTestClass
{
    public function __construct(int $sleepSeconds = 0)
    {
        sleep($sleepSeconds);
    }
}
