<?php

namespace Lavi\Middleware;

use Lavi\Request\IRequest;
use Psr\Container\ContainerInterface;
use Psr\Http\Message\ResponseInterface;

class Handler implements \Iterator
{
    private ContainerInterface $container;
    private array $middlewares;
    private $default;

    private int $index = 0;

    public function __construct(ContainerInterface $container, array $middleware, callable $default)
    {
        $this->container = $container;
        $this->middlewares = $middleware;
        $this->default = $default;
    }

    public function handle(IRequest $request): ResponseInterface
    {
        if (!$this->valid()) {
            return call_user_func($this->default, $request);
        }

        return $this->current()->process($request, $this->next());
    }

    public function current(): IMiddleware
    {
        return $this->container->make($this->middlewares[$this->index]);
    }

    public function next(): self
    {
        $self = clone $this;
        $self->index++;

        return $self;
    }

    public function key(): int
    {
        return $this->index;
    }

    public function valid(): bool
    {
        return isset($this->middlewares[$this->index]);
    }

    public function rewind()
    {
        $this->index = 0;
    }
}