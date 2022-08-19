<?php

/**
 * This file is part of the guanguans/laravel-proxy-manager.
 *
 * (c) guanguans <ityaozm@gmail.com>
 *
 * This source file is subject to the MIT license that is bundled.
 */

namespace Guanguans\LaravelProxyManagerTests\TestClasses;

class LocalObjectTestClass extends ValueHolderTestClass
{
    public function execute(): string
    {
        return __METHOD__;
    }

    public function bar(): string
    {
        return __METHOD__;
    }
}
