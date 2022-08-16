<?php

/**
 * This file is part of the guanguans/laravel-proxy-manager.
 *
 * (c) guanguans <ityaozm@gmail.com>
 *
 * This source file is subject to the MIT license that is bundled.
 */

namespace Guanguans\LaravelProxyManager\Tests\Benchmark;

use Guanguans\LaravelProxyManager\PackageSkeleton;

/**
 * @beforeMethods({"setUp"})
 * @warmup(2)
 * @revs(1000)
 * @iterations(15)
 */
final class PackageSkeletonBench
{
    /**
     * @var \Guanguans\LaravelProxyManager\PackageSkeleton
     */
    private $packageSkeleton;

    public function setUp(): void
    {
        $this->packageSkeleton = new PackageSkeleton();
    }

    public function benchTest(): void
    {
        // $this->packageSkeleton->test();
        PackageSkeleton::test();
    }
}
