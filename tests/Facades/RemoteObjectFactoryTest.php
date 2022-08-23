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
use Guanguans\LaravelProxyManagerTests\TestClasses\AbstractLocalBookObjectTestClass;
use Guanguans\LaravelProxyManagerTests\TestClasses\RemoteBookObjectAdapterTestClass;
use Guanguans\LaravelProxyManagerTests\TestClasses\RemoteBookObjectTestClass;
use Illuminate\Support\Facades\Route;
use ProxyManager\Proxy\RemoteObjectInterface;

beforeEach(function () {
    Route::get('book/{id}', function ($id) {
        return response()->json([
            'detail' => "Remote book #$id",
        ]);
    });

    Route::get('author/{id}', function ($id) {
        return response()->json([
            'detail' => "Remote author #$id",
        ]);
    });
});

it('will return `RemoteObject` proxy', function () {
    $proxy = RemoteObjectFactory::setAdapter(new RemoteBookObjectAdapterTestClass($remoteObjectTestClass = new RemoteBookObjectTestClass()))
        ->createProxy(AbstractLocalBookObjectTestClass::class);

    expect($proxy)
        ->toBeInstanceOf(AbstractLocalBookObjectTestClass::class)
        ->toBeInstanceOf(RemoteObjectInterface::class)
        ->and($proxy->book($id = 2))
        ->toEqual($remoteObjectTestClass->book($id))
        ->and($proxy->author($id))
        ->toEqual($remoteObjectTestClass->author($id));
});
