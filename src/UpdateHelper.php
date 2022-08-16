<?php

/**
 * This file is part of the guanguans/laravel-proxy-manager.
 *
 * (c) guanguans <ityaozm@gmail.com>
 *
 * This source file is subject to the MIT license that is bundled.
 */

namespace Guanguans\LaravelProxyManager;

use UpdateHelper\UpdateHelperInterface;

class UpdateHelper implements UpdateHelperInterface
{
    public function check(\UpdateHelper\UpdateHelper $helper)
    {
        $helper->write('Package update checking...');
        $helper->write('Package update checking done.');
    }
}
