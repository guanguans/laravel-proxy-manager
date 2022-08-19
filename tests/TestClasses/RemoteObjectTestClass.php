<?php

/**
 * This file is part of the guanguans/laravel-proxy-manager.
 *
 * (c) guanguans <ityaozm@gmail.com>
 *
 * This source file is subject to the MIT license that is bundled.
 */

namespace Guanguans\LaravelProxyManagerTests\TestClasses;

class RemoteObjectTestClass extends LocalObjectTestClass
{
    public function book($id)
    {
        return \Pest\Laravel\getJson("/book/$id")->json();
    }

    public function author($id)
    {
        return \Pest\Laravel\getJson("/author/$id")->json();
    }
}
