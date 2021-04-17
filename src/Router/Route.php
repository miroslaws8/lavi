<?php

namespace Lavi\Router;

class Route
{
    public const ROUTE_CONTROLLER = 'controller';
    public const ROUTE_METHOD = 'action';
    public const ROUTE_NAMESPACE = 'namespace';
    public const ROUTE_MIDDLEWARES = 'middlewares';

    private array $params;

    public function __construct(array $params)
    {
        $this->params = $params;
    }

    public function getParams(): array
    {
        return $this->params;
    }

    public function getController(): string
    {
        return $this->params[static::ROUTE_CONTROLLER];
    }

    public function getMethod(): string
    {
        return $this->params[static::ROUTE_METHOD];
    }

    public function getNamespace(): string
    {
        return $this->params[static::ROUTE_NAMESPACE];
    }

    public function getMiddlewares(): array
    {
        return $this->params[static::ROUTE_MIDDLEWARES];
    }
}