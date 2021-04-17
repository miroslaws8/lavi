<?php

namespace Lavi\Middleware;

use Lavi\Request\IRequest;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Psr\Http\Server\MiddlewareInterface;
use Psr\Http\Server\RequestHandlerInterface;

class Dispatcher
{
    private array $middlewares;

    public function __construct(array $middlewares)
    {
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
        $handler = new Handler($this->middlewares, $default);
        return $handler->handle($request);
    }

    public function process(IRequest $request, $nextContainerHandler): ResponseInterface
    {
        $handler = new Handler($this->middlewares, $nextContainerHandler);
        return $handler->handle($request);
    }
}