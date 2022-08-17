<?php

/**
 * This file is part of the guanguans/laravel-proxy-manager.
 *
 * (c) guanguans <ityaozm@gmail.com>
 *
 * This source file is subject to the MIT license that is bundled.
 */

namespace Guanguans\LaravelProxyManagerTests\TestClasses;

class AccessInterceptorScopeLocalizerTestClass extends ValueHolderTestClass
{
    public $counter = 0;

    public function fluentMethod(): self
    {
        ++$this->counter;

        return $this;
    }
}
