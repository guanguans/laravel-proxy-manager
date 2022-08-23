<?php

/**
 * This file is part of the guanguans/laravel-proxy-manager.
 *
 * (c) guanguans <ityaozm@gmail.com>
 *
 * This source file is subject to the MIT license that is bundled.
 */

namespace Guanguans\LaravelProxyManagerTests;

use Closure;
use Guanguans\LaravelProxyManager\ProxyManager;
use Guanguans\LaravelProxyManagerTests\TestClasses\AbstractLocalObjectTestClass;
use Guanguans\LaravelProxyManagerTests\TestClasses\AccessInterceptorScopeLocalizerTestClass;
use Guanguans\LaravelProxyManagerTests\TestClasses\AccessInterceptorValueHolderTestClass;
use Guanguans\LaravelProxyManagerTests\TestClasses\LazyLoadingGhostTestClass;
use Guanguans\LaravelProxyManagerTests\TestClasses\LazyLoadingValueHolderTestClass;
use Guanguans\LaravelProxyManagerTests\TestClasses\LocalObjectTestClass;
use Guanguans\LaravelProxyManagerTests\TestClasses\NullObjectTestClass;
use Guanguans\LaravelProxyManagerTests\TestClasses\RemoteObjectTestClass;
use Guanguans\LaravelProxyManagerTests\TestClasses\ValueHolderTestClass;
use InvalidArgumentException;
use ProxyManager\Factory\RemoteObject\AdapterInterface;
use ProxyManager\Proxy\AccessInterceptorInterface;
use ProxyManager\Proxy\AccessInterceptorValueHolderInterface;
use ProxyManager\Proxy\GhostObjectInterface;
use ProxyManager\Proxy\NullObjectInterface;
use ProxyManager\Proxy\RemoteObjectInterface;
use ProxyManager\Proxy\VirtualProxyInterface;

it('will return instance of `ProxyInterface`', function () {
    expect(new ProxyManager(app()))
        ->createAccessInterceptorScopeLocalizerProxy(new AccessInterceptorScopeLocalizerTestClass())
        ->toBeInstanceOf(AccessInterceptorInterface::class)
        ->createAccessInterceptorValueHolderProxy(new AccessInterceptorValueHolderTestClass())
        ->toBeInstanceOf(AccessInterceptorValueHolderInterface::class)
        ->createLazyLoadingGhostFactoryProxy(LazyLoadingGhostTestClass::class, function () {})
        ->toBeInstanceOf(GhostObjectInterface::class)
        ->createLazyLoadingValueHolderProxy(LazyLoadingValueHolderTestClass::class, function () {})
        ->toBeInstanceOf(VirtualProxyInterface::class)
        ->createNullObjectProxy(NullObjectTestClass::class)
        ->toBeInstanceOf(NullObjectInterface::class)
        ->createRemoteObjectProxy(AbstractLocalObjectTestClass::class, new class() implements AdapterInterface {
            public function call(string $wrappedClass, string $method, array $params = [])
            {
            }
        })
        ->toBeInstanceOf(RemoteObjectInterface::class);
});

it('will throw `Target class [unkown] does not exist. InvalidArgumentException` for `bindLazyLoadingValueHolderProxy`', function () {
    (new ProxyManager(app()))->bindLazyLoadingValueHolderProxy('unkown');
})->throws(InvalidArgumentException::class, 'Target class [unkown] does not exist.');

it('will throw `Target [Guanguans\LaravelProxyManagerTests\Unkown] is not instantiable. InvalidArgumentExceptio` for `bindLazyLoadingValueHolderProxy`', function () {
    interface Unkown
    {
    }

    (new ProxyManager(app()))->bindLazyLoadingValueHolderProxy(Unkown::class);
})->throws(InvalidArgumentException::class, 'Target [Guanguans\LaravelProxyManagerTests\Unkown] is not instantiable.');

it('will not return for `bindLazyLoadingValueHolderProxy`', function () {
    expect(new ProxyManager(app()))
        ->bindLazyLoadingValueHolderProxy(ValueHolderTestClass::class)
        ->toBeNull();

    expect(app(ValueHolderTestClass::class))
        ->toBeInstanceOf(ValueHolderTestClass::class)
        ->toBeInstanceOf(VirtualProxyInterface::class);

    expect(app(ValueHolderTestClass::class))
        ->execute()
        ->toBe('execute');
});

it('will not return for `singletonLazyLoadingValueHolderProxy`', function () {
    expect(new ProxyManager(app()))
        ->singletonLazyLoadingValueHolderProxy(ValueHolderTestClass::class)
        ->toBeNull();

    expect(app(ValueHolderTestClass::class))
        ->toBeInstanceOf(ValueHolderTestClass::class)
        ->toBeInstanceOf(VirtualProxyInterface::class);
});

it('will not return for `extendToAccessInterceptorScopeLocalizerProxy`', function () {
    expect(new ProxyManager(app()))
        ->extendToAccessInterceptorScopeLocalizerProxy(
            AccessInterceptorScopeLocalizerTestClass::class,
            [
                'fluentMethod' => static function (AccessInterceptorInterface $proxy, AccessInterceptorScopeLocalizerTestClass $realInstance) {
                    echo "before-fluentMethod: #$realInstance->counter\n";
                },
            ],
            [
                'fluentMethod' => static function (AccessInterceptorInterface $proxy, AccessInterceptorScopeLocalizerTestClass $realInstance) {
                    echo "after-fluentMethod: #$realInstance->counter\n";
                },
            ]
        )
        ->toBeNull()
        ->and(app(AccessInterceptorScopeLocalizerTestClass::class))
        ->fluentMethod()->fluentMethod()->fluentMethod()
        ->counter
        ->toEqual(3);
});

it('will not return for `extendToAccessInterceptorValueHolderProxy`', function () {
    expect(new ProxyManager(app()))
        ->extendToAccessInterceptorValueHolderProxy(
            AccessInterceptorValueHolderTestClass::class,
            [
                'execute' => function () {
                    echo "before-execute\n";
                },
            ],
            [
                'execute' => function () {
                    echo 'after-execute';
                },
            ]
        )
        ->toBeNull()
        ->and(app(AccessInterceptorValueHolderTestClass::class))
        ->execute()
        ->and(ob_get_contents())
        ->toEqual("before-execute\nafter-execute");
});

it('will not return for `extendToLazyLoadingGhostFactoryProxy`', function () {
    $id = 1;
    $name = 'name';
    expect(new ProxyManager(app()))
        ->extendToLazyLoadingGhostFactoryProxy(
            LazyLoadingGhostTestClass::class,
            function (GhostObjectInterface $proxy, string $method, array $parameters, &$initializer, array $properties) use ($id, $name) {
                $initializer = null;
                dump('Triggered lazy-loading');
                $properties["\0Guanguans\\LaravelProxyManagerTests\\TestClasses\\LazyLoadingGhostTestClass\0id"] = $id;
                $properties["\0Guanguans\\LaravelProxyManagerTests\\TestClasses\\LazyLoadingGhostTestClass\0name"] = $name;

                return true;
            },
            [
                'skippedProperties' => [
                    "\0Guanguans\\LaravelProxyManagerTests\\TestClasses\\LazyLoadingGhostTestClass\0id",
                ],
            ]
        )
        ->toBeNull()
        ->and(app(LazyLoadingGhostTestClass::class))
        ->getId()
        ->toBeNull()
        ->getName()
        ->toEqual($name);
});

it('will not return for `extendToLazyLoadingValueHolderProxy`', function () {
    expect(new ProxyManager(app()))
        ->extendToLazyLoadingValueHolderProxy(
            ValueHolderTestClass::class,
            function (?object &$wrappedObject, ?object $proxy, string $method, array $parameters, ?Closure &$initializer) {
                $initializer = null;
                $wrappedObject = new ValueHolderTestClass();

                return true;
            },
            []
        )
        ->toBeNull()
        ->and(app(ValueHolderTestClass::class))
        ->execute()
        ->toEqual((new ValueHolderTestClass())->execute());
});

it('will not return for `extendToNullObjectProxy`', function () {
    expect(new ProxyManager(app()))
        ->extendToNullObjectProxy(NullObjectTestClass::class)
        ->toBeNull()
        ->and(app(NullObjectTestClass::class))
        ->toBeInstanceOf(NullObjectTestClass::class)
        ->getId()
        ->toBeNull();
});

it('will not return for `extendToRemoteObjectProxy`', function () {
    expect(new ProxyManager(app()))
        ->extendToRemoteObjectProxy(LocalObjectTestClass::class, new class($remoteObjectTestClass = new RemoteObjectTestClass()) implements AdapterInterface {
            public function __construct(RemoteObjectTestClass $remoteObjectTestClass)
            {
                $this->remoteObjectTestClass = $remoteObjectTestClass;
            }

            public function call(string $wrappedClass, string $method, array $params = [])
            {
                return $this->remoteObjectTestClass->{$method}(...$params);
            }
        })
        ->toBeNull()
        ->and(app(LocalObjectTestClass::class))
        ->toBeInstanceOf(LocalObjectTestClass::class)
        ->book($id = 2)
        ->toEqual($remoteObjectTestClass->book($id))
        ->author($id)
        ->toEqual($remoteObjectTestClass->author($id));
});
