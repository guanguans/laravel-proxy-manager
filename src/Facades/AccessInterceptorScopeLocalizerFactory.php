<?php

/**
 * This file is part of the guanguans/laravel-proxy-manager.
 *
 * (c) guanguans <ityaozm@gmail.com>
 *
 * This source file is subject to the MIT license that is bundled.
 */

namespace Guanguans\LaravelProxyManager\Facades;

use Illuminate\Support\Facades\Facade;

class AccessInterceptorScopeLocalizerFactory extends Facade
{
    protected static function getFacadeAccessor()
    {
        return \ProxyManager\Factory\AccessInterceptorScopeLocalizerFactory::class;
    }
}
