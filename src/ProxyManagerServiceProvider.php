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
use Guanguans\LaravelProxyManager\Factories\RemoteObjectFactory;
use Illuminate\Contracts\Container\Container;
use Illuminate\Foundation\Console\AboutCommand;
use ProxyManager\Configuration;
use ProxyManager\Factory\AccessInterceptorScopeLocalizerFactory;
use ProxyManager\Factory\AccessInterceptorValueHolderFactory;
use ProxyManager\Factory\LazyLoadingGhostFactory;
use ProxyManager\Factory\LazyLoadingValueHolderFactory;
use ProxyManager\Factory\NullObjectFactory;
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
        $this->app->bind(FileLocatorInterface::class, function () {
            if (
                ! file_exists($proxiesDirectory = config('proxy-manager.generated_proxies_dir'))
                && ! mkdir($proxiesDirectory, config('proxy-manager.generated_proxies_dir_mode'), true)
                && ! is_dir($proxiesDirectory)
            ) {
                throw new RuntimeException(sprintf('Directory "%s" was not created', $proxiesDirectory));
            }

            return new FileLocator($proxiesDirectory);
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
        $this->app->singleton(ProxyManager::class);
    }

    public function packageBooted()
    {
        if (class_exists(AboutCommand::class)) {
            AboutCommand::add('Laravel Proxy Manager', [
                    'Author' => 'guanguans',
                    'Homepage' => 'https://github.com/guanguans/laravel-proxy-manager',
                    'License' => 'MIT',
                ]
            );
        }
    }
}
