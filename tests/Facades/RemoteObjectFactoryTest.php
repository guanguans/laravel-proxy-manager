<?php

/**
 * This file is part of the guanguans/laravel-proxy-manager.
 *
 * (c) guanguans <ityaozm@gmail.com>
 *
 * This source file is subject to the MIT license that is bundled.
 */

use Guanguans\LaravelProxyManagerTests\TestClasses\LocalObjectTestClass;
use Laminas\XmlRpc\Client;
use ProxyManager\Factory\RemoteObject\Adapter\XmlRpc;
use ProxyManager\Factory\RemoteObjectFactory;

beforeEach(function () {
    // exec(sprintf('php -S localhost:8765 "%s"', __DIR__.'/../stub/remote-proxy-server.php'));
});

it('Should execute a proxy remote method.', function () {
    // try {
    //     $factory = new RemoteObjectFactory(
    //         new XmlRpc(new Client('http://localhost:8765/remote-proxy-server.php'))
    //     );
    //
    //     $proxy = $factory->createProxy(LocalObjectTestClass::class);
    //
    //     expect($proxy)
    //         ->toBeInstanceOf(LocalObjectTestClass::class)
    //         ->and($proxy->execute())
    //         ->toEqual('execute');
    // } catch (Throwable $e) {
    //     dump($e->getFile().':'.$e->getLine().' '.$e->getMessage());
    // }
});
