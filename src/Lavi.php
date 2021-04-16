<?php

namespace Lavi;

use Lavi\Container\IContainer;
use Lavi\Exceptions\LaviException;
use Lavi\Exceptions\RouteException;
use Lavi\Request\IRequest;
use Lavi\Request\SymfonyRequestAdapter;
use Lavi\Config\Config;
use Lavi\Router\IRouter;

class Lavi
{
    public IRequest $request;
    private ?IContainer $container;

    public function __construct(IContainer $container = null)
    {
        $this->container = $container;
        $this->request = SymfonyRequestAdapter::createFromGlobals();
    }

    public function getContainer(): IContainer
    {
        return $this->container;
    }

    public function setRequest(IRequest $request)
    {
        $this->request = $request;
    }

    public function run(IRouter $router)
    {
        $handler = $router->dispatch($this->request->getPathInfo());

        if (!is_callable($handler)) {
            throw new RouteException('Action not found!');
        }

        try {
            $response = call_user_func($handler);
        } catch (LaviException $exception) {
            $response = $exception->getMessage();
        }

        return $response;
    }
}