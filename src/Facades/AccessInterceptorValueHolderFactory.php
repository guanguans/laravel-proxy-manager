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
 * @method static \ProxyManager\Proxy\AccessInterceptorValueHolderInterface createProxy(object $instance, array $prefixInterceptors = [], array $suffixInterceptors = [])
 *
 * @see \ProxyManager\Factory\AccessInterceptorValueHolderFactory
 */
class AccessInterceptorValueHolderFactory extends Facade
{
    protected static function getFacadeAccessor(): string
    {
        return \ProxyManager\Factory\AccessInterceptorValueHolderFactory::class;
    }
}
