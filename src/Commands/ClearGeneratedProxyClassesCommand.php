<?php

/**
 * This file is part of the guanguans/laravel-proxy-manager.
 *
 * (c) guanguans <ityaozm@gmail.com>
 *
 * This source file is subject to the MIT license that is bundled.
 */

namespace Guanguans\LaravelProxyManager\Commands;

use Illuminate\Console\Command;
use Symfony\Component\Finder\Finder;
use Symfony\Component\Finder\SplFileInfo;

class ClearGeneratedProxyClassesCommand extends Command
{
    protected $signature = 'proxy:clear';

    protected $description = 'Clear generated proxy classes';

    public function handle(): int
    {
        if (! file_exists(config('proxy-manager.generated_proxies_dir'))) {
            $this->info('Proxy classes directory not found.');

            return static::SUCCESS;
        }

        $fileInfos = Finder::create()
            ->in(config('proxy-manager.generated_proxies_dir'))
            ->files()
            ->name('*.php')
            ->ignoreDotFiles(true)
            ->ignoreVCS(true)
            ->ignoreUnreadableDirs();

        $this->info(sprintf('Found %d generated proxy classes', $fileInfos->count()));
        $this->info('Clearing generated proxy classes...');

        foreach ($fileInfos as $fileInfo) {
            /* @var SplFileInfo $fileInfo */
            $fileInfo->isWritable() ? unlink($fileInfo->getRealPath()) : $this->warn("{$fileInfo->getRealPath()} is not writable");
        }

        $this->info('Generated proxy classes have been cleared');

        return static::SUCCESS;
    }
}
