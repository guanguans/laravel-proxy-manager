<?php

/**
 * This file is part of the guanguans/laravel-proxy-manager.
 *
 * (c) guanguans <ityaozm@gmail.com>
 *
 * This source file is subject to the MIT license that is bundled.
 */

namespace Guanguans\LaravelProxyManagerTests\Facades;

use Guanguans\LaravelProxyManager\Facades\RemoteObjectFactory;
use Guanguans\LaravelProxyManagerTests\TestClasses\AbstractLocalObjectTestClass;
use Guanguans\LaravelProxyManagerTests\TestClasses\RemoteObjectTestClass;
use ProxyManager\Factory\RemoteObject\AdapterInterface;

it('should execute a proxy remote method', function () {
    $proxy = RemoteObjectFactory::setAdapter(new class($remoteObjectTestClass = new RemoteObjectTestClass()) implements AdapterInterface {
        public function __construct(RemoteObjectTestClass $remoteObjectTestClass)
        {
            $this->remoteObjectTestClass = $remoteObjectTestClass;
        }

        public function call(string $wrappedClass, string $method, array $params = [])
        {
            return $this->remoteObjectTestClass->{$method}(...$params);
        }
    })->createProxy(AbstractLocalObjectTestClass::class);

    expect($proxy)
        ->toBeInstanceOf(AbstractLocalObjectTestClass::class)
        ->and($proxy->book($id = 2))
        ->toEqual($remoteObjectTestClass->book($id))
        ->and($proxy->author($id))
        ->toEqual($remoteObjectTestClass->author($id));
});
