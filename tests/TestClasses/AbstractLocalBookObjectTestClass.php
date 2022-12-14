<?php

/**
 * This file is part of the guanguans/laravel-proxy-manager.
 *
 * (c) guanguans <ityaozm@gmail.com>
 *
 * This source file is subject to the MIT license that is bundled.
 */

namespace Guanguans\LaravelProxyManagerTests\TestClasses;

abstract class AbstractLocalBookObjectTestClass extends ValueHolderTestClass
{
    /**
     * @return array{detail: string}
     */
    public function book($id)
    {
        return [
            'detail' => "Local book #$id",
        ];
    }

    abstract public function author($id);
}
