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

class RemoteBookObjectAdapterTestClass implements AdapterInterface
{
    public function __construct(RemoteBookObjectTestClass $remoteObjectTestClass)
    {
        $this->remoteObjectTestClass = $remoteObjectTestClass;
    }

    public function call(string $wrappedClass, string $method, array $params = [])
    {
        return $this->remoteObjectTestClass->{$method}(...$params);
    }
}
