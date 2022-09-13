<?php

/**
 * This file is part of the guanguans/laravel-proxy-manager.
 *
 * (c) guanguans <ityaozm@gmail.com>
 *
 * This source file is subject to the MIT license that is bundled.
 */

namespace Guanguans\LaravelProxyManagerTests\TestClasses;

use function Pest\Laravel\get;
use function Pest\Laravel\getJson;

class RemoteBookObjectTestClass extends AbstractLocalBookObjectTestClass
{
    public function book($id)
    {
        return getJson("/book/$id")->json();
    }

    public function author($id)
    {
        return get("/author/$id")->json();
    }
}
