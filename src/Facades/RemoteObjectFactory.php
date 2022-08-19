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
 * @method static \ProxyManager\Proxy\RemoteObjectInterface createProxy($instanceOrClassName)
 * @method static \Guanguans\LaravelProxyManager\RemoteObjectFactory setAdapter(\ProxyManager\Factory\RemoteObject\AdapterInterface $adapter)
 *
 * @mixin \Guanguans\LaravelProxyManager\RemoteObjectFactory
 *
 * @see \Guanguans\LaravelProxyManager\RemoteObjectFactory
 */
class RemoteObjectFactory extends Facade
{
    protected static function getFacadeAccessor()
    {
        return \Guanguans\LaravelProxyManager\RemoteObjectFactory::class;
    }
}
