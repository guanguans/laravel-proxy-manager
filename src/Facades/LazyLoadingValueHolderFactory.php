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

/**
 * @method static \ProxyManager\Proxy\VirtualProxyInterface createProxy(string $className, \Closure $initializer, array $proxyOptions = [])
 *
 * @see \ProxyManager\Factory\LazyLoadingValueHolderFactory
 */
class LazyLoadingValueHolderFactory extends Facade
{
    protected static function getFacadeAccessor(): string
    {
        return \ProxyManager\Factory\LazyLoadingValueHolderFactory::class;
    }
}
