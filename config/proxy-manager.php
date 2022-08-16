<?php

/**
 * This file is part of the guanguans/laravel-proxy-manager.
 *
 * (c) guanguans <ityaozm@gmail.com>
 *
 * This source file is subject to the MIT license that is bundled.
 */

return [
    'proxies_dir' => env('PROXY_MANAGER_PROXIES_DIR', storage_path('app/proxies')),

    'generator_strategy_class' => env('PROXY_MANAGER_GENERATOR_STRATEGY_CLASS', \ProxyManager\GeneratorStrategy\FileWriterGeneratorStrategy::class),
];
