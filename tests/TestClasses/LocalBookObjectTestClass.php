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
    /**
     * @return array{detail: string}
     */
    public function author($id): array
    {
        return [
            'detail' => "Local author #$id",
        ];
    }
}
