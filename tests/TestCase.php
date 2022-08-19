<?php

/**
 * This file is part of the guanguans/laravel-proxy-manager.
 *
 * (c) guanguans <ityaozm@gmail.com>
 *
 * This source file is subject to the MIT license that is bundled.
 */

namespace Guanguans\LaravelProxyManagerTests;

use DMS\PHPUnitExtensions\ArraySubset\ArraySubsetAsserts;
use Guanguans\LaravelProxyManager\ProxyManagerServiceProvider;
use Illuminate\Support\Facades\Route;

class TestCase extends \Orchestra\Testbench\TestCase
{
    use ArraySubsetAsserts;

    /**
     * This method is called before the first test of this test class is run.
     */
    public static function setUpBeforeClass(): void
    {
    }

    /**
     * This method is called after the last test of this test class is run.
     */
    public static function tearDownAfterClass(): void
    {
    }

    /**
     * This method is called before each test.
     */
    protected function setUp(): void
    {
        parent::setUp();

        // \DG\BypassFinals::enable();

        $this->setUpRoutes();
    }

    /**
     * This method is called after each test.
     */
    protected function tearDown(): void
    {
        $this->finish();
        \Mockery::close();
    }

    /**
     * Run extra tear down code.
     */
    protected function finish()
    {
        // call more tear down methods
    }

    protected function getPackageProviders($app)
    {
        return [
            ProxyManagerServiceProvider::class,
        ];
    }

    public function getEnvironmentSetUp($app)
    {
    }

    protected function setUpRoutes()
    {
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
    }
}
