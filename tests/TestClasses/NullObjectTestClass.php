<?php

/**
 * This file is part of the guanguans/laravel-proxy-manager.
 *
 * (c) guanguans <ityaozm@gmail.com>
 *
 * This source file is subject to the MIT license that is bundled.
 */

namespace Guanguans\LaravelProxyManagerTests\TestClasses;

class NullObjectTestClass extends ValueHolderTestClass
{
    protected $id;

    public function __construct(?int $id)
    {
        $this->id = $id;
    }

    public function getId()
    {
        return $this->id;
    }
}
