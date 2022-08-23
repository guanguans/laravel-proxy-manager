<?php

/**
 * This file is part of the guanguans/laravel-proxy-manager.
 *
 * (c) guanguans <ityaozm@gmail.com>
 *
 * This source file is subject to the MIT license that is bundled.
 */

namespace Guanguans\LaravelProxyManagerTests\TestClasses;

class LocalBookObjectTestClass extends AbstractLocalBookObjectTestClass
{
    public function author($id)
    {
        return [
            'detail' => "Local author #$id",
        ];
    }
}
