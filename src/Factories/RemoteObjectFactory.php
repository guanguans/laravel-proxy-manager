<?php

/**
 * This file is part of the guanguans/laravel-proxy-manager.
 *
 * (c) guanguans <ityaozm@gmail.com>
 *
 * This source file is subject to the MIT license that is bundled.
 */

namespace Guanguans\LaravelProxyManager\Factories;

use ProxyManager\Configuration;
use ProxyManager\Factory\AbstractBaseFactory;
use ProxyManager\Factory\RemoteObject\AdapterInterface;
use ProxyManager\Proxy\RemoteObjectInterface;
use ProxyManager\ProxyGenerator\ProxyGeneratorInterface;
use ProxyManager\ProxyGenerator\RemoteObjectGenerator;
use ProxyManager\Signature\Exception\InvalidSignatureException;
use ProxyManager\Signature\Exception\MissingSignatureException;

/**
 * Factory responsible of producing remote proxy objects.
 */
class RemoteObjectFactory extends AbstractBaseFactory
{
    protected ?AdapterInterface $adapter;

    private RemoteObjectGenerator $generator;

    public function __construct(?AdapterInterface $adapter = null, ?Configuration $configuration = null)
    {
        parent::__construct($configuration);

        $this->adapter = $adapter;
        $this->generator = new RemoteObjectGenerator();
    }

    /**
     * @param string|object $instanceOrClassName
     *
     * @psalm-template RealObjectType of object
     *
     * @psalm-param RealObjectType|class-string<RealObjectType> $instanceOrClassName
     *
     * @psalm-return RealObjectType&RemoteObjectInterface
     *
     * @throws InvalidSignatureException
     * @throws MissingSignatureException
     * @throws \OutOfBoundsException
     * @throws \RuntimeException
     *
     * @psalm-suppress MixedInferredReturnType We ignore type checks here, since `staticProxyConstructor` is not
     *                                         interfaced (by design)
     */
    public function createProxy($instanceOrClassName, ?AdapterInterface $adapter = null): RemoteObjectInterface
    {
        $proxyClassName = $this->generateProxy(
            is_object($instanceOrClassName) ? get_class($instanceOrClassName) : $instanceOrClassName
        );

        $adapter = $adapter ?: $this->adapter;
        if (! $adapter instanceof AdapterInterface) {
            throw new \RuntimeException('No adapter set');
        }

        /*
         * We ignore type checks here, since `staticProxyConstructor` is not interfaced (by design)
         *
         * @psalm-suppress MixedMethodCall
         * @psalm-suppress MixedReturnStatement
         */
        return $proxyClassName::staticProxyConstructor($adapter);
    }

    public function setAdapter(AdapterInterface $adapter): self
    {
        $this->adapter = $adapter;

        return $this;
    }

    protected function getGenerator(): ProxyGeneratorInterface
    {
        return $this->generator;
    }
}
