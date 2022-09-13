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
use Illuminate\Support\Str;

class ClearGeneratedProxyClassesCommand extends Command
{
    /**
     * @var string
     */
    protected $signature = 'proxy:clear';

    /**
     * @var string
     */
    protected $description = 'Clear generated proxy classes';

    public function handle(): int
    {
        if (! file_exists($proxiesDir = config('proxy-manager.generated_proxies_dir'))) {
            $this->warn('Proxy classes directory not found.');

            return static::SUCCESS;
        }

        $files = glob(Str::of($proxiesDir)->finish('/')->append('*.php'));
        $this->info(sprintf('Found %d generated proxy classes', is_countable($files) ? count($files) : 0));
        $this->info('Clearing generated proxy classes...');

        foreach ($files as $file) {
            is_writable($file) ? unlink($file) : $this->warn("The $file is not writable");
        }

        $this->info('Generated proxy classes have been cleared');

        return static::SUCCESS;
    }
}
