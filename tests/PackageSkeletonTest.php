<?php

/**
 * This file is part of the guanguans/laravel-proxy-manager.
 *
 * (c) guanguans <ityaozm@gmail.com>
 *
 * This source file is subject to the MIT license that is bundled.
 */

namespace Guanguans\LaravelProxyManagerTests;

use Guanguans\LaravelProxyManager\PackageSkeleton;

final class PackageSkeletonTest extends TestCase
{
    public function testTest()
    {
        $this->assertTrue(PackageSkeleton::test());
    }
}
