<?php

/**
 * This file is part of the guanguans/laravel-proxy-manager.
 *
 * (c) guanguans <ityaozm@gmail.com>
 *
 * This source file is subject to the MIT license that is bundled.
 */

use Guanguans\LaravelProxyManagerTests\TestClasses\RemoteObjectTestClass;
use Laminas\XmlRpc\Server;

require_once __DIR__.'/../../vendor/autoload.php';

(static function () {
    $server = new Server();

    $server->setClass(new RemoteObjectTestClass(), 'LocalObjectTestClass');
    $server->setReturnResponse(false);

    $server->handle();
})();
