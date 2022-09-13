<?php

/**
 * This file is part of the guanguans/laravel-proxy-manager.
 *
 * (c) guanguans <ityaozm@gmail.com>
 *
 * This source file is subject to the MIT license that is bundled.
 */

namespace Guanguans\LaravelProxyManagerTests\TestClasses;

use ProxyManager\Factory\RemoteObject\AdapterInterface;

class RemoteNullObjectAdapterTestClass implements AdapterInterface
{
    public function call(string $wrappedClass, string $method, array $params = []): void
    {
    }
}
