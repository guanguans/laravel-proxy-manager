<?php

/**
 * This file is part of the guanguans/laravel-proxy-manager.
 *
 * (c) guanguans <ityaozm@gmail.com>
 *
 * This source file is subject to the MIT license that is bundled.
 */

namespace Guanguans\LaravelProxyManager;

/*
 * This file is part of the guanguans/laravel-proxy-manager.
 *
 * (c) guanguans <ityaozm@gmail.com>
 *
 * This source file is subject to the MIT license that is bundled.
 */

use UpdateHelper\UpdateHelperInterface;

class UpdateHelper implements UpdateHelperInterface
{
    public function check(\UpdateHelper\UpdateHelper $updateHelper): void
    {
        $updateHelper->write('The guanguans/laravel-proxy-manager update checking...');

        if (! $updateHelper->hasAsDependency('nikic/php-parser')) {
            /** @var \Composer\IO\ConsoleIO $io */
            $io = $updateHelper->getIo();
            $io->warning('The `nikic/php-parser` required to use `proxy:list` command.');
            $io->warning('You can install it with "composer require nikic/php-parser".');
        }

        $updateHelper->write('The guanguans/laravel-proxy-manager update checking done.');
    }
}
