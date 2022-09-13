<?php

/**
 * This file is part of the guanguans/laravel-proxy-manager.
 *
 * (c) guanguans <ityaozm@gmail.com>
 *
 * This source file is subject to the MIT license that is bundled.
 */

use ProxyManager\GeneratorStrategy\FileWriterGeneratorStrategy;

/*
 * This file is part of the guanguans/laravel-proxy-manager.
 *
 * (c) guanguans <ityaozm@gmail.com>
 *
 * This source file is subject to the MIT license that is bundled.
 */
return [
    /*
     * The proxy manager will use this directory to store generated proxies.
     */
    'generated_proxies_dir' => env('PROXY_MANAGER_GENERATED_PROXIES_DIR', storage_path('app/proxies')),

    /*
     * The proxy manager will use this mode to create the proxy directory.
     */
    'generated_proxies_dir_mode' => env('PROXY_MANAGER_GENERATED_PROXIES_DIR_MODE', 0755),

    /*
     * The proxy manager will use this strategy to generate proxies.
     *
     * ```php
     * [
     *     \ProxyManager\GeneratorStrategy\BaseGeneratorStrategy::class,
     *     \ProxyManager\GeneratorStrategy\FileWriterGeneratorStrategy::class,
     *     \ProxyManager\GeneratorStrategy\EvaluatingGeneratorStrategy::class
     * ]
     * ```
     */
    'generator_strategy_class' => env('PROXY_MANAGER_GENERATOR_STRATEGY_CLASS', FileWriterGeneratorStrategy::class),
];
