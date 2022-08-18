<?php

/**
 * This file is part of the guanguans/laravel-proxy-manager.
 *
 * (c) guanguans <ityaozm@gmail.com>
 *
 * This source file is subject to the MIT license that is bundled.
 */

namespace Guanguans\LaravelProxyManager;

use Guanguans\LaravelProxyManager\Commands\ClearGeneratedProxyClassesCommand;
use Guanguans\LaravelProxyManager\Commands\ListGeneratedProxyClassesCommand;
use Illuminate\Contracts\Container\Container;
use ProxyManager\Configuration;
use ProxyManager\Factory\AccessInterceptorScopeLocalizerFactory;
use ProxyManager\Factory\AccessInterceptorValueHolderFactory;
use ProxyManager\Factory\LazyLoadingGhostFactory;
use ProxyManager\Factory\LazyLoadingValueHolderFactory;
use ProxyManager\Factory\NullObjectFactory;
use ProxyManager\Factory\RemoteObjectFactory;
use ProxyManager\FileLocator\FileLocator;
use ProxyManager\FileLocator\FileLocatorInterface;
use RuntimeException;
use Spatie\LaravelPackageTools\Package;
use Spatie\LaravelPackageTools\PackageServiceProvider;

class ProxyManagerServiceProvider extends PackageServiceProvider
{
    public function configurePackage(Package $package): void
    {
        $package
            ->name('laravel-proxy-manager')
            ->hasConfigFile()
            ->hasCommands([
                ClearGeneratedProxyClassesCommand::class,
                ListGeneratedProxyClassesCommand::class,
            ]);
    }

    public function packageRegistered()
    {
        $this->app->bind(FileLocatorInterface::class, function (Container $container) {
            if (
                ! file_exists(config('proxy-manager.generated_proxies_dir'))
                && ! mkdir($concurrentDirectory = config('proxy-manager.generated_proxies_dir'), config('proxy-manager.generated_proxies_dir_mode'), true)
                && ! is_dir($concurrentDirectory)
            ) {
                throw new RuntimeException(sprintf('Directory "%s" was not created', $concurrentDirectory));
            }

            return new FileLocator(config('proxy-manager.generated_proxies_dir'));
        });

        $this->app->singleton(Configuration::class, function (Container $container) {
            $configuration = new Configuration();
            $configuration->setGeneratorStrategy($container->make(config('proxy-manager.generator_strategy_class')));
            $configuration->setProxiesTargetDir(config('proxy-manager.generated_proxies_dir'));
            spl_autoload_register($configuration->getProxyAutoloader());

            return $configuration;
        });

        $this->app->singleton(AccessInterceptorScopeLocalizerFactory::class);
        $this->app->singleton(AccessInterceptorValueHolderFactory::class);
        $this->app->singleton(LazyLoadingGhostFactory::class);
        $this->app->singleton(LazyLoadingValueHolderFactory::class);
        $this->app->singleton(NullObjectFactory::class);
        $this->app->singleton(RemoteObjectFactory::class);
    }
}
