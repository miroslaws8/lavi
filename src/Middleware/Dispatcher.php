<?php

namespace Lavi\Middleware;

use Lavi\Request\IRequest;
use Psr\Container\ContainerInterface;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Psr\Http\Server\MiddlewareInterface;
use Psr\Http\Server\RequestHandlerInterface;

class Dispatcher
{
    private ContainerInterface $container;
    private array $middlewares;

    public function __construct(ContainerInterface $container, array $middlewares)
    {
        $this->container = $container;
        $this->middlewares = $middlewares;
    }

    public function append(MiddlewareInterface $middleware): void
    {
        array_push($this->middlewares, $middleware);
    }

    public function prepend(MiddlewareInterface $middleware): void
    {
        array_unshift($this->middlewares, $middleware);
    }

    public function dispatch(IRequest $request, callable $default): ResponseInterface
    {
        $handler = $this->container->make(Handler::class, [
            'middleware' => $this->middlewares,
            'default' => $default
        ]);

        return $handler->handle($request);
    }

    public function process(IRequest $request, $nextContainerHandler): ResponseInterface
    {
        $handler = new Handler($this->middlewares, $nextContainerHandler);
        return $handler->handle($request);
    }
}