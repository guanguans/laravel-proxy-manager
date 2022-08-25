<?php

/**
 * This file is part of the guanguans/laravel-proxy-manager.
 *
 * (c) guanguans <ityaozm@gmail.com>
 *
 * This source file is subject to the MIT license that is bundled.
 */

namespace Guanguans\LaravelProxyManager;

use Guanguans\LaravelProxyManager\Concerns\BindProxy;
use Guanguans\LaravelProxyManager\Concerns\CreateProxy;
use Guanguans\LaravelProxyManager\Concerns\ExtendToProxy;
use Illuminate\Container\Container;

class ProxyManager
{
    use BindProxy;
    use CreateProxy;
    use ExtendToProxy;

    protected Container $container;

    public function __construct(Container $container)
    {
        $this->container = $container;
    }
}
